<?php

namespace App\Http\Controllers\Admin\TransactionPoint;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransactionPoint\CreateTransactionPointRequest;
use App\Http\Requests\Admin\TransactionPoint\UpdateTransactionPointRequest;
use App\Models\Employee;
use App\Models\Order;
use App\Models\TransactionPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit');
        $transaction_points = TransactionPoint::search('name', 'address')
            ->with('ward.district.province')
            ->orderBy('updated_at', 'desc')
            ->paginate($limit ?: 10);
        return $this->json(compact('transaction_points'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionPointRequest $request)
    {
        $req = $request->all();
        $req_manager = $request->manager;
        $transaction_point = TransactionPoint::create($req)->load('ward.district.province');
        if ($req_manager) {
            $req_manager['transaction_point_id'] = $transaction_point->id;
            $req_manager['password'] = bcrypt($req_manager['password']);
            $req_manager['profile_number'] = Str::random(5);
            $manager = Employee::create($req_manager)->assignRole('manager');
        }
        return $this->json(compact('transaction_point'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction_point = TransactionPoint::where('id', $id)
            ->with('ward.district.province')
            ->firstOrFail();
        return $this->json(compact('transaction_point'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionPointRequest $request, $id)
    {
        $transaction_point = TransactionPoint::findOrFail($id);
        $req = $request->all();
        $transaction_point->update($req);
        $transaction_point->load('ward.district.province');
        return $this->json(compact('transaction_point'));
    }
}
