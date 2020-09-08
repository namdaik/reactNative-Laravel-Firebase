<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Staff\CreateStaffManagerRequest;
use App\Http\Requests\Admin\Staff\UpdateStaffManagerRequest;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StaffManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction_point_id = $this->guard()->user()->transaction_point_id;
        $limit = request()->get('limit');
        $staffs = Employee::whereHas('thisRoles', function ($query) use ($transaction_point_id) {
            $query->where(function ($query) {
                $query->where('roles.name', '=', 'receptionist')
                    ->orWhere('roles.name', '=', 'shipper');
            });
            $query->where('employees.transaction_point_id', '=', $transaction_point_id);
        })->with('transactionPoint.ward.district.province')
            ->paginate($limit ?: 10);
        foreach ($staffs as $staffkey => $staff) {
            $staffs[$staffkey]->role = $staffs[$staffkey]->thisRoles->first()->name;
            unset($staffs[$staffkey]->thisRoles);
        }
        return $this->json(compact('staffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStaffManagerRequest $request)
    {
        $req = $request->all();
        $req['transaction_point_id'] = $this->guard()->user()->transaction_point_id;
        $req['password'] = bcrypt($req['password']);
        $req['profile_number'] = Str::random(5);
        $manager = Employee::create($req)->assignRole($req['roles']);
        $manager->load('transactionPoint.ward.district.province');
        return $this->json(compact('manager'));
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
        $staff = Employee::where('id', $id)
            ->where('transaction_point_id', $transaction_point_id)
            ->with('transactionPoint.ward.district.province')
            ->firstOrFail();
        $staff->role = $staff->thisRoles->first()->name;
        unset($staff->thisRoles);
        if ($staff->hasAnyRole(['receptionist', 'shipper'])) {
            $role_names = Role::pluck('name', 'name')->only('receptionist', 'shipper');
            unset($staff->roles);
            return $this->json(compact('staff', 'role_names'));
        }
        throw new AuthorizationException;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffManagerRequest $request, $id)
    {
        $transaction_point_id = $this->guard()->user()->transaction_point_id;
        $staff = Employee::where('id',$id)->where('transaction_point_id',$transaction_point_id)->with('transactionPoint.ward.district.province')->firstOrFail();
        $req = $request->all();
        if ($staff->hasAnyRole(['receptionist', 'shipper'])) {
            if (!empty($req['roles'])) {
                $req = $request->only('is_active', 'roles');
                $staff->update($req);
                $staff->syncRoles($req['roles']);
            } else {
                $req = $request->only('is_active');
                $staff->update($req);
            }
            return $this->json(compact('staff'));
        }
        throw new AuthorizationException;
    }

    private function guard()
    {
        return Auth::guard('api-employee');
    }
}
