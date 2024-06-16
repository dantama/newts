<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use  App\Models\Traits\MemberTrait;
use App\Models\Traits\Restorable\Restorable;

class Member extends Model
{
    use Restorable;

    /**
     * The table associated with the model.
     */
    protected $table = 'ts_members';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'nbts', 'nbm', 'qr', 'regency_id', 'joined_at', 'perwil', 'perwil_id'
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

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->where($this->getRouteKeyName(), $value)->first();
    }


    protected static function booted()
    {
        static::addGlobalScope('perwil', function (Builder $builder) {
            $builder->where('perwil', false);
        });
    }

    /**
     * This belongsTo user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    /**
     * This belongsTo regency.
     */
    public function regency()
    {
        return $this->belongsTo(ManagementRegency::class, 'regency_id')->withDefault();
    }

    public function perwildata()
    {
        return $this->belongsTo(ManagementPerwil::class, 'perwil_id')->withDefault();
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

    /**
     * Where having managerial in.
     */
    public function scopeInManagerial($q, $managerial)
    {
        $management = $managerial->pivot;

        return $q->when($management->managerable_type == 'App\\Models\\ManagementCenter', function ($query) use ($managerial) {
            return $query->whereIn('id', $managerial->load('provinces.regencies')->pluck('provinces.regencies.id')->toArray());
        })->when($managerial->managerable_type == 'App\\Models\\ManagementProvince', function ($query) use ($managerial) {
            return $query->whereIn('id', $managerial->load('regencies')->pluck('regencies.id')->toArray());
        })->when($managerial->managerable_type == 'App\\Models\\ManagementRegency', function ($query) use ($managerial) {
            return $query->whereIn('id', $managerial->pluck('id')->toArray());
        });
    }

    public function scopeIsPerwil($q)
    {
        $q->withoutGlobalScopes()->where('perwil', true);
    }
}
