<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\FullTextSearch;

/**
 * Class User
 *
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 *
 * @method static User create(array $user)
 * @package App
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles, FullTextSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'gender', 'address', 'is_active', 'phone', 'mobile_tokens'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function placeOfShipments()
    {
        return $this->hasMany(PlaceOfShipment::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function shippingHistories()
    {
        return $this->hasManyThrough(ShippingHistory::class, Order::class, 'user_id', 'order_id');
    }

    public function scopeFilterStatus($query, $request)
    {
        if ($request->status_user == 'active') {
            $query->where('is_active', 1);
        }
        if ($request->status_user == 'ban') {
            $query->where('is_active', 0);
        }
        return $query;
    }

    /**
     * Set permissions guard to API by default
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * @inheritdoc
     */
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

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        foreach ($this->roles  as $role) {
            if ($role->isAdmin()) {
                return true;
            }
        }
        return false;
    }

    public function getMobileTokensAttribute()
    {
        return json_decode($this->attributes['mobile_tokens']) ?: [];
    }

    public function saveMobileToken($value)
    {
        if ($value && is_string($value)) {
            $token = $this->mobile_tokens;
            if (!in_array($value, $token) && preg_match('/^ExponentPushToken\[.+\]$/', $value)) {
                $token[] = $value;
                $this->attributes['mobile_tokens'] = json_encode($token);
                $this->save();
            }
        }
    }

    public function removeMobileToken($value)
    {
        if ($value && is_string($value)) {
            $this->attributes['mobile_tokens'] = array_diff($this->mobile_tokens, array($value));
            $this->save();
        }
    }
}
