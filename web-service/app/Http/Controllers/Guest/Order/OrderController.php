<?php

namespace App\Http\Controllers\Guest\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Order\SearchOrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function search(SearchOrderRequest $request)
    {
        $order_id = $request->order_id;
        $order = Order::where('id', $order_id)
            ->with(
                'transactionPoint.ward.district.province',
                'placeOfShipment.ward.district.province',
                'shippingHistories.transactionPoint.ward.district.province',
                'employee',
                'user'
            )
            ->firstOrFail();
        return $this->json(compact('order'));
    }

    public function searchInBlade(SearchOrderRequest $request)
    {
        $order_id = $request->get('order_id');
        $order = Order::where('id', $order_id)
            ->with(
                'transactionPoint.ward.district.province',
                'placeOfShipment.ward.district.province',
                'shippingHistories.transactionPoint.ward.district.province',
                'employee',
                'user'
            )
            ->firstOrFail();
        //  return $this->json(compact('order'));
        return view('show-order', compact('order'));
    }
}
