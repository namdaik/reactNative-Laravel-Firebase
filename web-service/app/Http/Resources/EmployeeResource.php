<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $permissions_all = $this->getPermissionsViaRoles();
        foreach($permissions_all as $permission){
            $permissions_name[] = $permission->name;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'transaction_point_id' => $this->transaction_point_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'gender' => $this->gender,
            'address' => $this->address,
            'is_active' => $this->is_active,
            'profile_number' => $this->profile_number,
            'role' => $this->roles->first()->name,
            'permissions' => $permissions_name,
        ];
    }
}
