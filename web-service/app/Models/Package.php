<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'packages';
    protected $fillable = [
        'order_ids', 'transaction_point_id', 'next_transaction_point_id', 'employee_id', 'next_employee_id', 'deleted_by'
    ];
    protected $appends = ['orders'];
    public function transactionPoint()
    {
        return $this->belongsTo(TransactionPoint::class, 'transaction_point_id');
    }

    public function getOrdersAttribute()
    {
        $order_ids = $this->order_ids;
        return Order::whereIn('id', json_decode($order_ids))->with('placeOfShipment.ward.district.province','user')->get();
    }

    public function fromTransactionPoint()
    {
        return $this->belongsTo(TransactionPoint::class, 'transaction_point_id');
    }

    public function nextTransactionPoint()
    {
        return $this->belongsTo(TransactionPoint::class, 'next_transaction_point_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function deletedBy()
    {
        return $this->belongsTo(Employee::class, 'deleted_by');
    }

    public function shipper()
    {
        return $this->belongsTo(Employee::class, 'next_employee_id');
    }
}
