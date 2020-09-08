<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingHistory extends Model
{
    protected $table = 'shipping_histories';
    protected $fillable = ['order_id', 'employee_id', 'order_status', 'transaction_point_id'];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function transactionPoint()
    {
        return $this->belongsTo(TransactionPoint::class, 'transaction_point_id');
    }
}
