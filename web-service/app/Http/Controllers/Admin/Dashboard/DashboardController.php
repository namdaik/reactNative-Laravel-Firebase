<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use App\Models\TransactionPoint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        if ($request->has('order_by_year')) {
            for ($i = $now->year - 2; $i <= $now->year; $i++) {
                $orders[$i] = count(Order::whereYear('created_at', $i)->get());
            }
        }
        if ($request->has('order_by_month')) {
            for ($i = 0; $i < 6; $i++) {
                $end = $now->subMonth($i)->endOfMonth();
                $start = Carbon::now()->subMonth($i)->startOfMonth();
                $orders[$start->month . '-' . $start->year] = count(Order::whereRaw(
                    "(created_at >= ? AND created_at <= ?)",
                    [$start, $end]
                )->get());
            }
        }
        if ($request->has('order_last_7_days')) {
            for ($i = 0; $i < 7; $i++) {
                $day = new Carbon();
                $start = $day->now()->subDays($i)->startOfDay()->toDateTimeString();
                $end = $day->now()->subDays($i)->endOfDay()->toDateTimeString();
                $orders[$day->now()->subDays($i)->toDateString()] = count(Order::whereBetween('created_at', [$start, $end])->get());
            }
        }
        $employees = count(Employee::all());
        $trasaction_points = count(TransactionPoint::all());
        $users = count(User::all());
        return $this->json(compact('orders', 'employees', 'trasaction_points', 'users'));
    }
}
