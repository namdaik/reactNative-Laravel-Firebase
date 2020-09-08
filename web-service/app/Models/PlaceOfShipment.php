<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceOfShipment extends Model
{
    protected $table = 'place_of_shipments';
    protected $fillable = ['name', 'user_id', 'address', 'phone', 'province_id', 'district_id', 'ward_id'];
    protected $appends = ['ward'];
    public function orders()
    {
        return $this->hasMany(Order::class, 'place_of_shipment_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function getWardAttribute()
    {
        return Ward::where('id', $this->attributes['ward_id'])->with('district.province')->first();
    }
}
