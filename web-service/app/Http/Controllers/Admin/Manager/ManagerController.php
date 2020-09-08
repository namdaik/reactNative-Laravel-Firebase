<?php

namespace App\Http\Controllers\Admin\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Manager\CreateManagerRequest;
use App\Http\Requests\Admin\Manager\UpdateManagerRequest;
use App\Models\Employee;
use App\Models\TransactionPoint;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @var $employees has employees where role name is manager
     * @return $employees
     */
    public function index()
    {
        $limit = request()->get('limit');
        $managers = Employee::whereHas('thisRoles', function ($query) {
            $query->where('roles.name', '=', 'manager');
        })->with('transactionPoint.ward.district.province')
            ->paginate($limit ?: 10);
        return $this->json(compact('managers'));
    }

    public function showTransactionPoints()
    {
        $data = TransactionPoint::all()->load('ward.district.province');
        $transaction_points = [];
        foreach ($data as $key => $val) {
            if (count($val->manager) == 0) {
                $transaction_points[] = $val;
            }
        }
        return $this->json(compact('transaction_points'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param $request
     * @return $manager
     */
    public function store(CreateManagerRequest $request)
    {
        $req = $request->all();
        $req['password'] = bcrypt($req['password']);
        $req['profile_number'] = Str::random(5);
        $manager = Employee::create($req)->assignRole('manager');
        $manager->load('transactionPoint.ward.district.province');
        return $this->json(compact('manager'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id is id of employee has role manager
     * @var  array employee is information of manager
     * @param  int  $id is id of employee has role manager
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $manager = Employee::findOrFail($id)->load('transactionPoint.ward.district.province');
        $transaction_points = TransactionPoint::all()->load('ward.district.province');
        if ($manager->hasRole('manager')) {
            return $this->json(compact('manager', 'transaction_points'));
        }
        throw new AuthorizationException;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id is uuid of employee has role manager
     * @var $manager is manager updated
     * @return $manager after update
     */
    public function update(UpdateManagerRequest $request, $id)
    {
        $manager = Employee::findOrFail($id);
        if ($manager->hasRole('manager')) {
            $is_active = $request->only('is_active');
            $manager->update($is_active);
            $manager->load('transactionPoint.ward.district.province');
            return $this->json(compact('manager'));
        }
        throw new AuthorizationException;
    }
}
