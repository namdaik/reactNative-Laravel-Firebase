<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit;
        $users = User::filterStatus($request)
            ->search('name', 'phone', 'email')
            ->paginate($limit ?: 10);
        $users->makeHidden('orders');
        return $this->json(compact('users'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $limit = request()->get('limit');
        $user = User::where('id', $id)
            ->firstOrFail();
        $orders = $user->orders()->with(
            'placeOfShipment.ward.district.province',
            'shippingHistories.transactionPoint.ward.district.province',
            'shippingHistories.employee'
        )->paginate($limit?:10);
        return $this->json(compact('user', 'orders'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $req = $request->only('is_active');
        $user = User::findOrFail($id);
        $user->update($req);
        $user->load(
            'orders.placeOfShipment.ward.district.province',
            'orders.shippingHistories.transactionPoint.ward.district.province',
            'orders.shippingHistories.employee'
        );
        return $this->json(compact('user'));
    }
}
