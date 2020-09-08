<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $table = 'employees';
    protected $fillable = ['name', 'avatar', 'gender', 'address', 'is_active', 'password', 'transaction_point_id', 'is_active', 'email', 'phone', 'profile_number'];
    protected $hidden = ['password'];
    protected $guard_name = 'api-employee';

    public function transactionPoint()
    {
        return $this->belongsTo(TransactionPoint::class, 'transaction_point_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'employee_id');
    }

    public function shippingHistories()
    {
        return $this->hasMany(ShippingHistory::class, 'employee_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritdoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function thisRoles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }
}
