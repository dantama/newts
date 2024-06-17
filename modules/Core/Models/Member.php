<?php

namespace Modules\Core\Models;

use App\Models\Traits\Metable\Metable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Modules\Account\Models\User;
use Modules\Core\Enums\MembershipTypeEnum;

class Member extends Model
{
    use Restorable, Searchable, Metable;

    /**
     * The table associated with the model.
     */
    protected $table = 'members';

    /**
     * Define the meta table
     */
    protected $metaTable = 'members_meta';

    /**
     * Define the meta key name
     */
    public $metaKeyName = 'member_id';

    /**
     * Prevent meta from being populated
     */
    public $hideMeta = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'nbts', 'nbm', 'qr', 'joined_at'
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
        'type' => MembershipTypeEnum::class
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
