<?php

namespace Modules\Core\Models;

use App\Models\Traits\Restorable\Restorable;
use Illuminate\Database\Eloquent\Model;
use Modules\Account\Models\User;

class Manager extends Model
{
    use Restorable;

    protected $table = "org_managers";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'managerable_type', 'managerable_id', 'position_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->where($this->getRouteKeyName(), $value)->first();
    }

    /**
     * This belongsTo User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * This belongsTo position.
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function managerable()
    {
        return $this->morphTo();
    }

    /**
     * This scope where in center.
     */
    public function scopeInCenter($query)
    {
        return $query->where('managerable_type', 'App\Models\ManagementCenter');
    }

    /**
     * This scope where management centers.
     */
    public function scopeWhereManagementCentersIn($query, $id)
    {
        return $query->inCenter()->whereIn('managerable_id', (array) $id);
    }

    /**
     * This scope where in province.
     */
    public function scopeInProvince($query)
    {
        return $query->where('managerable_type', 'App\Models\ManagementProvince');
    }

    /**
     * This scope where management provinces.
     */
    public function scopeWhereManagementProvincesIn($query, $id)
    {
        return $query->inProvince()->whereIn('managerable_id', (array) $id);
    }

    public function scopeInPerwil($query)
    {
        return $query->where('managerable_type', 'App\Models\ManagementPerwil');
    }

    /**
     * This scope where management provinces.
     */
    public function scopeWhereManagementPerwilIn($query, $id)
    {
        return $query->inPerwil()->whereIn('managerable_id', (array) $id);
    }

    /**
     * This scope where in regency.
     */
    public function scopeInRegency($query)
    {
        return $query->where('managerable_type', 'App\Models\ManagementRegency');
    }

    /**
     * This scope where management regency.
     */
    public function scopeWhereManagementRegenciesIn($query, $id)
    {
        return $query->inRegency()->whereIn('managerable_id', (array) $id);
    }

    /**
     * This scope where in district.
     */
    public function scopeInDistrict($query)
    {
        return $query->where('managerable_type', 'App\Models\ManagementDistrict');
    }

    /**
     * This scope where management district.
     */
    public function scopeWhereManagementDistrictIn($query, $id)
    {
        return $query->inDistrict()->whereIn('managerable_id', (array) $id);
    }
}
