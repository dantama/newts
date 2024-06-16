<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Modules\Account\Models\User;

class Member extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = 'org_members';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'nbts', 'nbm', 'qr', 'regency_id', 'joined_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'perwil' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [];


    protected static function booted()
    {
        // 
    }

    /**
     * This belongsTo user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    /**
     * This hasMany levels.
     */
    public function level()
    {
        return $this->hasOne(MemberLevel::class, 'member_id')->latest();
    }

    /**
     * This hasMany levels.
     */
    public function levels()
    {
        return $this->hasMany(MemberLevel::class, 'member_id');
    }

    /**
     * Scope where code in.
     */
    public function scopeWhereCodeIn($query, $value)
    {
        return $query->whereHas('levels.detail', function ($code) use ($value) {
            return $code->whereIn('code', (array) $value);
        });
    }

    /**
     * Scope where regency in.
     */
    public function scopeWhereRegencyIn($query, $value)
    {
        return $query->whereIn('regency_id', (array) $value);
    }
}
