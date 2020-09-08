<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $timestamp = false;
    protected $table = 'wards';
    public function transactionPoints()
    {
        return $this->hasMany(TransactionPoint::class, 'ward_id');
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
