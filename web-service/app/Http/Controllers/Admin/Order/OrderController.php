<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\CreateOrderRequest;
use App\Http\Requests\Admin\Order\SearchUserRequest;
use App\Http\Requests\Admin\Order\UpdateOrderRequest;
use App\Http\Requests\User\Order\SearchOrderRequest;
use App\Models\Order;
use App\Models\PlaceOfShipment;
use App\Models\ShippingHistory;
use App\Models\TransactionPoint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($option = 'all')
    {
        $transaction_point_id = $this->guard()->user()->transaction_point_id;
        $transaction_point_name = TransactionPoint::where('id', $transaction_point_id)
            ->select('name')
            ->firstOrFail();
        $limit = request()->get('limit');
        switch ($option) {
                // crud package with case here
            case 'confirmed':
                // dd('a');
                $orders = Order::where('transaction_point_id', $transaction_point_id)
                    ->where('status', 1)
                    ->orderBy('updated_at', 'asc')
                    ->with('user', 'employee', 'placeOfShipment.ward.district.province', 'transactionPoint.ward.district.province')
                    ->paginate($limit ?: 10);
                break;
                // crud package with case here
            case 'in-stock':
                $orders = Order::where('transaction_point_id', $transaction_point_id)
                    ->where('status', 3)
                    ->orderBy('updated_at', 'asc')
                    ->with('user', 'employee', 'placeOfShipment.ward.district.province', 'transactionPoint.ward.district.province')
                    ->paginate($limit ?: 10);
                break;
                // crud package with case here
            case 'delivery':
                $orders = Order::where('transaction_point_id', $transaction_point_id)
                    ->where('status', 4)
                    ->orderBy('updated_at', 'asc')
                    ->with('user', 'employee', 'placeOfShipment.ward.district.province', 'transactionPoint.ward.district.province')
                    ->paginate($limit ?: 10);
                break;

            case 'done':
                $orders = Order::where('transaction_point_id', $transaction_point_id)
                    ->where('status', 5)
                    ->orderBy('updated_at', 'asc')
                    ->with('user', 'employee', 'placeOfShipment.ward.district.province', 'transactionPoint.ward.district.province', 'lastShippingHistory')
                    ->paginate($limit ?: 10);
                break;

            case 'return':
                $orders = Order::where('transaction_point_id', $transaction_point_id)
                    ->where('status', -1)
                    ->orderBy('updated_at', 'asc')
                    ->with('user', 'employee', 'placeOfShipment.ward.district.province', 'transactionPoint.ward.district.province', 'lastShippingHistory')
                    ->paginate($limit ?: 10);
                break;

            default:
                $orders = Order::where('transaction_point_id', $transaction_point_id)
                    ->whereNotIn('status', [0, 2])
                    ->orderBy('updated_at', 'asc')
                    ->with('user', 'employee', 'placeOfShipment.ward.district.province', 'transactionPoint.ward.district.province')
                    ->paginate($limit ?: 10);
                break;
        }
        return $this->json(compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $transaction_point_id = $this->guard()->user()->transaction_point_id;
        $employee_id = $this->guard()->user()->id;
        $req = $request->all();
        $req['id'] = Str::random(6);
        $req['receivers'] = json_encode($req['receivers']);
        $req['transaction_point_id'] = $transaction_point_id;
        $req['employee_id'] = $employee_id;
        $req['status'] = 1;
        if ($request->user_id && $request->place_of_shipment_id) {
            $req['user_id'] = $request->user_id;
            $req['place_of_shipment_id'] = $request->place_of_shipment_id;
            $place_of_shipment_found = PlaceOfShipment::findOrFail($req['place_of_shipment_id']);
            $user_found = User::findOrFail($req['user_id']);
            $order = Order::create($req);
        } else {
            if (empty($request->user_id)) {
                $req['user']['password'] = bcrypt('password');
                $req['user']['gender'] = 1;
                $user = User::create($req['user']);
                $req['user_id'] = $user->id;
                $req['place_of_shipment']['user_id'] =  $user->id;
            } else {
                $req['place_of_shipment']['user_id'] =  $request->user_id;
            }
            $place_of_shipment_created = PlaceOfShipment::create($req['place_of_shipment']);
            $req['place_of_shipment_id'] = $place_of_shipment_created->id;
            $order = Order::create($req);
        }
        $order->load('employee', 'transactionPoint.ward.district.province', 'lastShippingHistory', 'placeOfShipment.ward.district.province', 'user');
        return $this->json(compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction_point_id = $this->guard()->user()->transaction_point_id;
        $order = Order::where('id', $id)
            ->where('transaction_point_id', $transaction_point_id)
            ->where('status', '!=', 2)
            ->where('status', '!=', 0)
            ->with('employee', 'user', 'placeOfShipment.ward.district.province', 'transactionPoint.ward.district.province')
            ->firstOrFail();
        return $this->json(compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request)
    {
        $id = $request->order_id;
        $order = Order::where('id', $id)
            ->where('status', 0)
            ->firstOrFail();
        $req = $request->only(['is_paid']);
        $req['employee_id'] = $this->guard()->user()->id;
        $req['transaction_point_id'] = $this->guard()->user()->transaction_point_id;
        $req['status'] = 1;
        $order->update($req);
        $order->load('user', 'lastShippingHistory', 'placeOfShipment.ward.district.province', 'transactionPoint.ward.district.province');
        return $this->json(compact('order'));
    }


    private function guard()
    {
        return Auth::guard('api-employee');
    }

    public function searchUser(SearchUserRequest $request)
    {
        $phone = $request->phone;
        $user = User::where('phone', $phone)
            ->where('is_active', true)
            ->firstOrFail();
        foreach ($user->placeOfShipments as $p) {
            $p->ward->district->province;
        }
        return $this->json(compact('user'));
    }

    public function searchOrder(SearchOrderRequest $request)
    {
        $order_id = $request->get('order_id');
        $order = Order::where('id', $order_id)
            ->where('status', 0)
            ->with('user')
            ->with('placeOfShipment.ward.district.province')
            ->firstOrFail();
            unset($order->user->avatar);
        return $this->json(compact('order'));
    }
}
