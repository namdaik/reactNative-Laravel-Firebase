<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{

    protected $timestamp = false ;
    protected $table = 'provinces';

    public function districts()
    {
        return $this->hasMany(District::class,'province_id');
    }

    public function transactionPoints()
    {
        return $this->hasMany(TransactionPoint::class,'province_id');
    }

    public function wards()
    {
        return $this->hasManyThrough(Ward::class, District::class);
    }
}
