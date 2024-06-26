<?php

namespace Modules\Core\Models;

use App\Models\Traits\Metable\Metable;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use Restorable, Searchable, Metable;

    /**
     * Define the table
     */
    protected $table = "managers";

    /**
     * Define the meta table
     */
    protected $metaTable = 'managers_meta';

    /**
     * Define the meta key name
     */
    public $metaKeyName = 'manager_id';

    /**
     * Prevent meta from being populated
     */
    public $hideMeta = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'member_id', 'unit_dept_id', 'start_at', 'end_at', 'meta'
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
    protected $casts = [
        'meta' => 'object',
        'deleted_at' => 'datetime', 'created_at' => 'datetime', 'deleted_at' => 'datetime', 'start_at' => 'datetime', 'end_at' => 'datetime'
    ];

    /**
     * This belongsTo User.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /**
     * This belongsTo unit departement.
     */
    public function unit_departement()
    {
        return $this->belongsTo(UnitDepartement::class, 'unit_dept_id');
    }

    /**
     * This has one cvontract.
     */
    public function contract()
    {
        return $this->hasOne(ManagerContract::class, 'manager_id')->latest();
    }

    /**
     * This has many contract.
     */
    public function contracts()
    {
        return $this->hasMany(ManagerContract::class, 'manager_id');
    }

    /**
     * This scope active.
     */
    public function scopeActive($query)
    {
        return $query->where('start_at', '<=', now())->where('end_at', '>=', now());
    }

    /**
     * This scope where in center.
     */
    public function scopeInCenter($query)
    {
        // return $query->where('managerable_type', 'App\Models\ManagementCenter');
    }

    /**
     * This scope where management centers.
     */
    public function scopeWhereManagementCentersIn($query, $id)
    {
        // return $query->inCenter()->whereIn('managerable_id', (array) $id);
    }

    /**
     * This scope where in province.
     */
    public function scopeInProvince($query)
    {
        // return $query->where('managerable_type', 'App\Models\ManagementProvince');
    }

    /**
     * This scope where management provinces.
     */
    public function scopeWhereManagementProvincesIn($query, $id)
    {
        // return $query->inProvince()->whereIn('managerable_id', (array) $id);
    }

    public function scopeInPerwil($query)
    {
        // return $query->where('managerable_type', 'App\Models\ManagementPerwil');
    }

    /**
     * This scope where management provinces.
     */
    public function scopeWhereManagementPerwilIn($query, $id)
    {
        // return $query->inPerwil()->whereIn('managerable_id', (array) $id);
    }

    /**
     * This scope where in regency.
     */
    public function scopeInRegency($query)
    {
        // return $query->where('managerable_type', 'App\Models\ManagementRegency');
    }

    /**
     * This scope where management regency.
     */
    public function scopeWhereManagementRegenciesIn($query, $id)
    {
        // return $query->inRegency()->whereIn('managerable_id', (array) $id);
    }

    /**
     * This scope where in district.
     */
    public function scopeInDistrict($query)
    {
        // return $query->where('managerable_type', 'App\Models\ManagementDistrict');
    }

    /**
     * This scope where management district.
     */
    public function scopeWhereManagementDistrictIn($query, $id)
    {
        // return $query->inDistrict()->whereIn('managerable_id', (array) $id);
    }
}
