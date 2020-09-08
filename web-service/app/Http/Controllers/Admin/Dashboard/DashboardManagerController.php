<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardManagerController extends Controller
{
    public function index(Request $request)
    {
        $transaction_point_id = $this->guard()->user()->transaction_point_id;
        $staffs = count(Employee::whereHas('thisRoles', function ($query) use ($transaction_point_id) {
            $query->where('employees.transaction_point_id', '=', $transaction_point_id);
            $query->where(function ($query) {
                $query->where('roles.name', '=', 'receptionist')
                    ->orWhere('roles.name', '=', 'shipper');
            });
        })->get());
        $packages = count(Package::where('transaction_point_id', $transaction_point_id)->get());
        $orders = count(Order::where('transaction_point_id', $transaction_point_id)->where('status', '!=', 2)->get());
        return $this->json(compact('staffs', 'packages', 'orders'));
    }

    private function guard()
    {
        return Auth::guard('api-employee');
    }
}
