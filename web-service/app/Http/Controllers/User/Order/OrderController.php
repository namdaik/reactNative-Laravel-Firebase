<?php

namespace App\Http\Controllers\User\Order;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Order\OrderRequest;
use App\Http\Requests\User\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Models\PlaceOfShipment;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param $all is default
     * @param $new is order with status = 0
     * @param $done is order with status = 5
     * @param $paid is order with is_paid = 1
     * @return $order is list orders by conditional
     */
    public function index($option = 'all')
    {
        $id = Auth::user()->id;
        $limit = request()->get('limit');
        switch ($option) {
            case 'new':
                $orders = Order::where('user_id', $id)
                    ->where('status', '0')
                    ->with('placeOfShipment.ward.district.province', 'employee', 'shippingHistories')
                    ->paginate($limit ?: 10);
                break;

            case 'done':
                $orders = Order::where('user_id', $id)
                    ->where('status', '5')
                    ->with('placeOfShipment.ward.district.province', 'employee', 'shippingHistories', 'lastShippingHistory')
                    ->paginate($limit ?: 10);
                break;

            case 'paided':
                $orders = Order::where('user_id', $id)
                    ->where('is_paid', '1')
                    ->with('placeOfShipment.ward.district.province', 'employee', 'shippingHistories')
                    ->paginate($limit ?: 10);
                break;

            default:
                $orders = Order::where('user_id', $id)
                    ->findByStatus(request())
                    ->sortByCreated(request())
                    ->with('placeOfShipment.ward.district.province', 'employee', 'shippingHistories')
                    ->paginate($limit ?: 10);
        }
        return $this->json(compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $request->receivers is array.
     * @param $user_id is user login
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $req = $request->all();
        $req['id'] = Str::random(6);
        $req['receivers'] = json_encode($req['receivers']);
        $req['user_id'] = Auth::user()->id;
        if (empty($req['place_of_shipment_id'])) {
            $req['place_of_shipment']['user_id'] = Auth::user()->id;
            $place_of_shipment = PlaceOfShipment::create($req['place_of_shipment']);
            $req['place_of_shipment_id'] = $place_of_shipment->id;
        }
        $req['status'] = 0;
        $order_created = Order::create($req);
        $order = Order::where('id', $order_created->id)
            ->with('shippingHistories', 'placeOfShipment.ward.district.province')
            ->firstOrFail();
        return $this->json(compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id is waybill
     * @param  $user_id is user login
     * @return $order
     */
    public function show($id)
    {
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)
            ->where('id', $id)
            ->firstOrFail()
            ->load(
                'placeOfShipment.ward.district.province',
                'shippingHistories',
                'user',
                'employee.transactionPoint'
            );
        return $this->json(compact('order'));
    }

    /**
     * @return \App\Http\Controllers\Controller@json
     */
    public function showTop5PlaceOfShipment()
    {
        $user_id = Auth::user()->id;
        $place_of_shipments = PlaceOfShipment::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        return $this->json(compact('place_of_shipments'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  $user_id is user login
     * @return $order
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)
            ->where('id', $id)
            ->where('status', 0)
            ->firstOrFail();
        $req = $request->only([
            'is_paid',
            'parcel_width',
            'parcel_length',
            'parcel_height',
            'parcel_weight',
            'parcel_description',
            'note',
            'price'
        ]);
        $order->update($req);
        $order->load('shippingHistories', 'placeOfShipment.ward.district.province');
        return $this->json(compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)
            ->where('id', $id)
            ->where('status', 0)
            ->firstOrFail()->delete();
        $message = 'Delete order successfully';
        return $this->json(compact('message'));
    }

    public function getProvincesAndDistrictsAndWards()
    {
        $provinces = Province::with('districts.wards')->get();
        return $this->json(compact('provinces'));
    }
}
