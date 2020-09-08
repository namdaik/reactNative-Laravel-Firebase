<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $orders_new = count(Order::where('user_id', $user_id)->where('status', '0')->get());
        $orders_confirmed = count(Order::where('user_id', $user_id)->where('status', '1')->get());
        $orders_transporting = count(Order::where('user_id', $user_id)->where('status', '2')->get());
        $orders_in_stock = count(Order::where('user_id', $user_id)->where('status', '3')->get());
        $orders_delivering = count(Order::where('user_id', $user_id)->where('status', '4')->get());
        $orders_done = count(Order::where('user_id', $user_id)->where('status', '5')->get());
        $orders_return = count(Order::where('user_id', $user_id)->where('status', '-1')->get());
        $orders_paided = count(Order::where('user_id', $user_id)->where('is_paid', '1')->get());
        $total_orders = count(Order::where('user_id', $user_id)->get());

        $now = Carbon::now();
        if ($request->has('order_by_year')) {
            for ($i = $now->year - 2; $i <= $now->year; $i++) {
                $orders[$i] = count(Order::whereYear('created_at', $i)->where('user_id', $user_id)->get());
            }
        }
        if ($request->has('order_by_month')) {
            for ($i = 0; $i < 6; $i++) {
                $end = $now->subMonth($i)->endOfMonth();
                $start = Carbon::now()->subMonth($i)->startOfMonth();
                $orders[$start->month . '-' . $start->year] = count(Order::whereRaw(
                    "(created_at >= ? AND created_at <= ?)",
                    [$start, $end]
                )->where('user_id', $user_id)->get());
            }
        }
        if ($request->has('order_last_7_days')) {
            for ($i = 0; $i < 7; $i++) {
                $day = new Carbon();
                $start = $day->now()->subDays($i)->startOfDay()->toDateTimeString();
                $end = $day->now()->subDays($i)->endOfDay()->toDateTimeString();
                $orders[$day->now()->subDays($i)->toDateString()] = count(Order::whereBetween('created_at', [$start, $end])->where('user_id', $user_id)->get());
            }
        }

        return $this->json(compact(
            'orders_new',
            'orders_confirmed',
            'orders_transporting',
            'orders_in_stock',
            'orders_delivering',
            'orders_done',
            'orders_paided',
            'orders_return',
            'total_orders',
            'orders'
        ));
    }
}
