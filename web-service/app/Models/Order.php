<?php

namespace App\Models;

use App\Traits\NotifiUserWhenUpdate;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use NotifiUserWhenUpdate;

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            ShippingHistory::create([
                'order_id' => $model->id,
                'employee_id' => $model->employee_id,
                'order_status' => $model->status,
                'transaction_point_id' => $model->transaction_point_id,
            ]);
        });
    }
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'orders';
    protected $fillable = [
        'id',
        'employee_id',
        'transaction_point_id',
        'status',
        'is_paid',
        'is_return',
        'place_of_shipment_id',
        'user_id',
        'receivers',
        'price',
        'parcel_width',
        'parcel_length',
        'parcel_height',
        'parcel_weight',
        'parcel_description',
        'note'
    ];

    public function placeOfShipment()
    {
        return $this->belongsTo(PlaceOfShipment::class, 'place_of_shipment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function transactionPoint()
    {
        return $this->belongsTo(TransactionPoint::class, 'transaction_point_id');
    }

    public function shippingHistories()
    {
        return $this->hasMany(ShippingHistory::class, 'order_id')->orderBy('id', 'DESC');
    }

    public function lastShippingHistory()
    {
        return $this->shippingHistories()->limit(1);
    }

    public function getReceiversAttribute()
    {
        $receivers =  json_decode($this->attributes['receivers']);
        $receivers->ward = Ward::where('id', $receivers->ward)->with('district.province')->first();
        return $receivers;
    }

    public function setIdAttribute($value)
    {
        return $this->attributes['id'] = strtoupper($value);
    }

    public function scopeFindById($query, $request)
    {
        if ($request->has('search')) {
            $query->where('id', $request->search);
        }
        return $query;
    }

    public function scopeFindTransactionPoint($query, $transaction_point)
    {
        $query->where('transaction_point_id', $transaction_point);
        return $query;
    }

    public function scopeFindByStatusForCreatePackage($query, $request)
    {
        if ($request->status == 1  || $request->status == 3 || $request->status == -1) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', [-1, 1, 3]);
        }
        return $query;
    }

    public function scopeFindByStatus($query, $request)
    {
        $type_status = ['0', '1', '2', '3', '4', '5', '-1'];
        $status = $request->status;
        if (in_array($status, $type_status)) {
            $query->where('status', $status);
        }
        return $query;
    }

    public function scopeSortByCreated($query, $request)
    {
        $type_orderBy = ['asc', 'desc'];
        $sort_created = $request->get('sort_created');
        if (in_array($sort_created, $type_orderBy)) {
            $query->orderBy('created_at', $sort_created);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        return $query;
    }
}
