<?php

namespace App\Models;

use App\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;

class TransactionPoint extends Model
{
    use FullTextSearch;
    protected $table = 'transaction_points';
    protected $fillable = ['name', 'province_id', 'district_id', 'ward_id', 'address'];
    protected $appends = ['manager'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'transaction_point_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'transaction_point_id');
    }

    public function shippingHistories()
    {
        return $this->hasMany(ShippingHistory::class, 'transaction_point_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function getManagerAttribute()
    {
        return Employee::whereHas('thisRoles', function ($query) {
            $query->where('roles.name', '=', 'manager');
            $query->where('employees.transaction_point_id', $this->id);
            $query->where('employees.is_active', 1);
        })->get();
    }
}
