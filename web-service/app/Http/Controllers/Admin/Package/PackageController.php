<?php

namespace App\Http\Controllers\Admin\Package;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Package\CreatePackageForShipper;
use App\Http\Requests\Admin\Package\CreatePackageSendRequest;
use App\Http\Requests\Admin\Package\UpdatePackageShipperRequest;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Package;
use App\Models\TransactionPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($option = 'all')
    {
        $transaction_point_id = $this->guard()->user()->transaction_point_id;
        $limit = request()->get('limit');
        $transaction_point_name = TransactionPoint::where('id', $transaction_point_id)
            ->select('name')
            ->firstOrFail();
        switch ($option) {
            case 'sent':
                $packages = Package::where('transaction_point_id', $transaction_point_id)
                    ->whereNotNull('next_transaction_point_id')
                    ->whereNull('next_employee_id')
                    ->orderBy('created_at', 'asc')
                    ->with('employee', 'nextTransactionPoint.ward.district.province', 'fromTransactionPoint.ward.district.province')
                    ->paginate($limit ?: 10);
                return $this->json(compact('packages'));

            case 'comming':
                $packages = Package::where('next_transaction_point_id', $transaction_point_id)
                    ->orderBy('created_at', 'asc')
                    ->with('employee', 'nextTransactionPoint.ward.district.province', 'fromTransactionPoint.ward.district.province')
                    ->paginate($limit ?: 10);
                return $this->json(compact('packages'));

            case 'arrived':
                $packages = Package::onlyTrashed()
                    ->where('next_transaction_point_id', $transaction_point_id)
                    ->orderBy('created_at', 'asc')
                    ->with('deletedBy', 'employee', 'nextTransactionPoint.ward.district.province', 'fromTransactionPoint.ward.district.province')
                    ->paginate($limit ?: 10);
                return $this->json(compact('packages'));

            case 'shipper-delivering':
                $packages = Package::where('transaction_point_id', $transaction_point_id)
                    ->whereNotNull('next_employee_id')
                    ->whereNull('next_transaction_point_id')
                    ->orderBy('created_at', 'asc')
                    ->with('employee', 'shipper', 'fromTransactionPoint.ward.district.province')
                    ->paginate($limit ?: 10);
                return $this->json(compact('packages'));

            case 'shipper-delivered':
                $packages = Package::onlyTrashed()
                    ->where('transaction_point_id', $transaction_point_id)
                    ->whereNotNull('next_employee_id')
                    ->orderBy('created_at', 'asc')
                    ->with('deletedBy', 'shipper', 'employee', 'fromTransactionPoint.ward.district.province')
                    ->paginate($limit ?: 10);
                return $this->json(compact('packages'));

            default:
                $count_sent = count(
                    Package::where('transaction_point_id', $transaction_point_id)
                        ->whereNotNull('next_transaction_point_id')
                        ->whereNull('next_employee_id')
                        ->get()
                );
                $count_comming = count(
                    Package::where('next_transaction_point_id', $transaction_point_id)
                        ->get()
                );
                $count_arrived = count(
                    Package::onlyTrashed()
                        ->where('next_transaction_point_id', $transaction_point_id)
                        ->get()
                );
                $count_shipper_delevering = count(
                    Package::where('transaction_point_id', $transaction_point_id)
                        ->whereNotNull('next_employee_id')
                        ->whereNull('next_transaction_point_id')
                        ->get()
                );
                $count_shipper_delivered = count(
                    Package::onlyTrashed()
                        ->where('transaction_point_id', $transaction_point_id)
                        ->whereNotNull('next_employee_id')
                        ->get()
                );
                return $this->json(compact('count_sent', 'count_comming', 'count_arrived', 'count_shipper_delevering', 'count_shipper_delivered'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createPackageSend(CreatePackageSendRequest $request)
    {
        $employee_login =  $this->guard()->user();
        $req = $request->only('order_ids', 'next_transaction_point_id');
        $req['order_ids'] = json_encode($request->order_ids);
        $transaction_point_id = $this->guard()->user()->transaction_point_id;
        $req['transaction_point_id'] = $transaction_point_id;
        $transaction_point_name = TransactionPoint::where('id', $transaction_point_id)
            ->select('name')
            ->firstOrFail();
        $req['employee_id'] =  $employee_login->id;
        $package_sent = Package::create($req)->load('employee', 'nextTransactionPoint.ward.district.province', 'fromTransactionPoint.ward.district.province');
        $orders = Order::whereIn('id',  $request->order_ids)->get();
        foreach ($orders as $order) {
            $order->update([
                'status' => 2,
                'transaction_point_id' => $transaction_point_id,
                'employee_id' => $req['employee_id']
            ]);
        }
        return $this->json(compact('package_sent'));
    }


    public function createPackageShipperDelivering(CreatePackageForShipper $request)
    {
        $employee_login =  $this->guard()->user();
        $req = $request->only('order_ids', 'next_employee_id');
        $req['order_ids'] = json_encode($request->order_ids);
        $transaction_point_id = $employee_login->transaction_point_id;
        $req['transaction_point_id'] = $transaction_point_id;
        $transaction_point_name = TransactionPoint::where('id', $transaction_point_id)
            ->select('name')
            ->firstOrFail();
        $req['employee_id'] =  $employee_login->id;
        $package_shipping = Package::create($req)->load('shipper', 'fromTransactionPoint.ward.district.province');
        $orders = Order::whereIn('id',  $request->order_ids)->get();
        foreach ($orders as $order) {
            $order->update([
                'status' => 4,
                'transaction_point_id' => $transaction_point_id,
                'employee_id' => $req['next_employee_id']
            ]);
        }
        return $this->json(compact('package_shipping'));
    }


    //  - transaction_point_id = me, next != me, next_employee!=null //done
    //  - transaction_point_id != me , next = me, next_employee!=null //done
    //  - transaction_point_id = me, next_employee!=null     //done
    public function show($id)
    {
        $transaction_point_id_of_user_loged_in = $this->guard()->user()->transaction_point_id;
        $package = Package::withTrashed()
            ->where('id', $id)
            ->where(function ($query) use ($transaction_point_id_of_user_loged_in) {
                $query->orWhere('next_transaction_point_id', $transaction_point_id_of_user_loged_in)
                    ->orWhere('transaction_point_id', $transaction_point_id_of_user_loged_in);
            })
            ->firstOrFail()
            ->load('deletedBy', 'shipper', 'fromTransactionPoint', 'nextTransactionPoint', 'employee');
        return $this->json(compact('package'));
    }
    //  tao giao shipper 5 đơn hàng trong 1 package
    //  shipper giao thành công 4 đơn, 1 đơn bị trả lại
    //  set status 4 đơn thành công, 1 đơn return

    // kho A chuyển đến kho B 10 đơn hàng
    // kho B kiểm kê và chỉ nhận được 9 đơn hàng
    // set status và thay đổi transaction_point_id của order 9 đơn. 1 đơn ? => nghiệp vụ

    // các trường hợp thanh toán đối với đơn hàng bị trả lại:
    // 1. trường hợp đơn hàng chưa thanh toán, người nhận cũng không thanh toán => price * 2, is_paid = 0   //Quân
    // 3. trường hợp đơn hàng đã thanh toán, người nhận hàng không thanh toán => price , is_paid = 0   // 15k , is_paid = 0
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePackageForShipper(UpdatePackageShipperRequest $request, $id)
    {
        $transaction_point_id_of_user_loged_in = $this->guard()->user()->transaction_point_id;
        $employee_logged_id = $this->guard()->user()->id;
        $order_returned_id = $request->order_returned_id;
        $package = Package::where('id', $id)
            ->where(function ($query) use ($transaction_point_id_of_user_loged_in) {
                $query->where('transaction_point_id', $transaction_point_id_of_user_loged_in);
                $query->whereNull('next_transaction_point_id');
                $query->whereNotNull('next_employee_id');
            })
            ->firstOrFail();
        $order_ids_in_package = json_decode($package->order_ids);
        if ($order_returned_id) {
            $req_order = [];
            $orders_returned = Order::whereIn('id', $order_returned_id)->get();
            foreach ($orders_returned as $order_returned) {
                if ($order_returned->is_paid == 0) {
                    $req_order['price'] = $order_returned->price * 2;
                }
                if ($order_returned->is_paid == 1) {
                    $req_order['is_paid'] = 0;
                }
                $req_order['status'] = -1;
                $req_order['is_return'] = 1;
                $req_order['transaction_point_id'] = $transaction_point_id_of_user_loged_in;
                $req_order['employee_id'] = $employee_logged_id;
                $order_returned->update($req_order);
            }
            $orders_success = Order::whereIn('id', array_diff($order_ids_in_package, $order_returned_id))->get();
            foreach ($orders_success as $order_success) {
                $order_success->update([
                    'is_paid' => 1,
                    'status' => 5,
                    'transaction_point_id' => $transaction_point_id_of_user_loged_in,
                    'employee_id' => $employee_logged_id
                ]);
            }
        } else {
            $orders_success = Order::whereIn('id', $order_ids_in_package)->get();
            foreach ($orders_success as $order_success) {
                $order_success->update([
                    'status' => 5,
                    'is_paid' => 1,
                    'transaction_point_id' => $transaction_point_id_of_user_loged_in,
                    'employee_id' => $employee_logged_id
                ]);
            }
        }
        $package->update(['deleted_by' => $employee_logged_id]);
        $package->delete();
        $package = Package::withTrashed()->where('id', $id)->with('deletedBy', 'fromTransactionPoint.ward.district.province', 'shipper', 'employee')->firstOrFail();
        return $this->json(compact('package'));
    }

    public function updatePackageComming($id)
    {
        $transaction_point_id_of_user_loged_in = $this->guard()->user()->transaction_point_id;
        $employee_logged_id = $this->guard()->user()->id;
        $package = Package::where('id', $id)
            ->where(function ($query) use ($transaction_point_id_of_user_loged_in) {
                $query->where('next_transaction_point_id', $transaction_point_id_of_user_loged_in);
                $query->where('transaction_point_id', '!=', $transaction_point_id_of_user_loged_in);
                $query->whereNull('next_employee_id');
            })
            ->firstOrFail();
        $orders_success = Order::whereIn('id', json_decode($package->order_ids))->get();
        foreach ($orders_success as $order_success) {
            $order_success->update([
                'status' => 3,
                'transaction_point_id' => $transaction_point_id_of_user_loged_in,
                'employee_id' => $employee_logged_id
            ]);
        }
        $package->update(['deleted_by' => $employee_logged_id]);
        $package->delete();
        $package = Package::withTrashed()->where('id', $id)->with('deletedBy', 'fromTransactionPoint.ward.district.province', 'nextTransactionPoint.ward.district.province', 'shipper', 'employee')->firstOrFail();
        return $this->json(compact('package'));
    }

    public function showTransactionPointForSend()
    {
        $transaction_point_id_of_user_loged_in = $this->guard()->user()->transaction_point_id;
        $transaction_points = TransactionPoint::where('id', '!=', $transaction_point_id_of_user_loged_in)->with('ward.district.province')->get();
        return $this->json(compact('transaction_points'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function listOrderForCreatePackage(Request $request)
    {
        $transaction_point_id_of_user_loged_in = $this->guard()->user()->transaction_point_id;
        $limit = request()->get('limit');
        $orders = Order::findTransactionPoint($transaction_point_id_of_user_loged_in)
            ->findByStatusForCreatePackage($request)
            ->sortByCreated($request)
            ->findById($request)
            ->with('employee', 'user', 'transactionPoint.ward.district.province', 'placeOfShipment.ward.district.province')
            ->paginate($limit ?: 10);
        return $this->json(compact('orders'));
    }

    public function listShipperForCreatePackage()
    {
        $transaction_point_id_of_user_loged_in = $this->guard()->user()->transaction_point_id;
        $limit = request()->get('limit');
        $shippers = Employee::whereHas('thisRoles', function ($query) use ($transaction_point_id_of_user_loged_in) {
            $query->where(function ($query) {
                $query->where('roles.name', '=', 'shipper');
            });
            $query->where('employees.transaction_point_id', '=', $transaction_point_id_of_user_loged_in);
            $query->where('employees.is_active', true);
        })->with('transactionPoint.ward.district.province')
            ->paginate($limit ?: 10);
        return $this->json(compact('shippers'));
    }

    private function guard()
    {
        return Auth::guard('api-employee');
    }
}
