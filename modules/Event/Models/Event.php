<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ManagementProvince;
use App\Models\ManagementRegency;
use App\Models\ManagementDistrict;

class Event extends Model
{
    use SoftDeletes;

    protected $table = "ts_events";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'management_type', 'management_id', 'name', 'content', 'registrable', 'content', 'type_id', 'price', 'start_at', 'end_at', 'state', 'file'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'start_at', 'end_at', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'approved' => 'boolean'
    ];

    /**
     * The relations to eager load on every query.
     */
    public $with = [
        'type'
    ];

    protected $appends = [
        'mgmt_name'
    ];

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->where($this->getRouteKeyName(), $value)->first();
    }

    /**
     * This belongs type.
     */
    public function type()
    {
        return $this->belongsTo(EventType::class, 'type_id');
    }

    /**
     * This has many registrants through exam.
     */
    public function registrants()
    {
        return $this->hasMany(EventRegistrant::class, 'event_id');
    }

    /**
     * This scope where in center.
     */
    public function scopeInCenter($query)
    {
        return $query->where('management_type', 'App\Models\ManagementCenter');
    }

    /**
     * This scope where management centers.
     */
    public function scopeWhereCentersIn($query, $id)
    {
        return $query->inCenter()->whereIn('management_id', (array) $id);
    }

    /**
     * This scope where in province.
     */
    public function scopeInProvince($query)
    {
        return $query->where('management_type', 'App\Models\ManagementProvince');
    }

    /**
     * This scope where management provinces.
     */
    public function scopeWhereProvinceIn($query, $id)
    {
        return $query->inProvince()->whereIn('management_id', (array) $id);
    }

    /**
     * This scope where in regency.
     */
    public function scopeInRegency($query)
    {
        return $query->where('management_type', 'App\Models\ManagementRegency');
    }

    /**
     * This scope where management regencies.
     */

    public function scopeWhereRegencyIn($query, $id)
    {
        return $query->inRegency()->whereIn('management_id', (array) $id);
    }

    /**
     * This scope where management regency.
     */
    public function scopeWhereManagementRegenciesIn($query, $id)
    {
        return $query->inRegency()->whereIn('managerable_id', (array) $id);
    }

    /**
     * This scope where management regency.
     */
    public function scopeWhereManagementIn($query, $management)
    {
        return $query->where('management_type', $management->managerable_type)
            ->where('management_id', $management->managerable_id);
    }

    /**
     * This scope where management regency.
     */
    public function scopeFromManagerial($query, $user)
    {
        $managerial = $user->flattenManagerials()->first();

        return $query->when($managerial->pivot->managerable_type == 'App\Models\ManagementRegency', function ($sq) {
            return $sq->inProvince();
        })->when($managerial->pivot->managerable_type == 'App\Models\ManagementProvince', function ($sq) {
            return $sq->inCenter();
        });
    }

    /**
     * This time range.
     */
    public function timeRange()
    {
        if ($this->start_at && $this->end_at) {
            return join(' - ', [$this->start_at->ISOFormat('ll'), $this->end_at->ISOFormat('ll')]);
        }
        return null;
    }

    public function getMgmtNameAttribute()
    {
        if ($this->management_type === 'App\Models\ManagementProvince') {
            $mgmt_name = ManagementProvince::where('id', $this->management_id)->first()->name;
        } else if ($this->management_type === 'App\Models\ManagementRegency') {
            $mgmt_name = ManagementRegency::where('id', $this->management_id)->first()->name;
        } else if ($this->management_type === 'App\Models\ManagementDistrict') {
            $mgmt_name = ManagementDistrict::where('id', $this->management_id)->first()->name;
        } else {
            $mgmt_name = 'Pimpinan Pusat';
        }

        return $mgmt_name;
    }
}
