<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;

class UserFcmToken extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'token'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * This belongs to user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * When user id.
     */
    public function scopeWhenUserId($query, $id)
    {
        return $query->when($id, fn ($query, $id) => $query->whereUserId($id));
    }
}
