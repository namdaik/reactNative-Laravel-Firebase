<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $timestamp = false;
    protected $table = 'districts';

    public function transactions()
    {
        return $this->hasMany(TransactionPoint::class, 'district_id');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
