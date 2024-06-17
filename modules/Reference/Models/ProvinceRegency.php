<?php

namespace Modules\Reference\Models;

use App\Scopes\OrderByNameScope;
use Illuminate\Database\Eloquent\Model;

class ProvinceRegency extends Model
{
    protected $table = "ref_province_regencies";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'province_id', 'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'province_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [];

    /**
     * The attributes that define validation rules.
     */
    public static $rules = [
        'province_id'       => 'required|integer|exists:provinces,id',
        'name'              => 'required|string'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'full'
    ];

    /**
     * This has many districts.
     */
    public function districts()
    {
        return $this->hasMany(ProvinceRegencyDistrict::class);
    }

    /**
     * This belongs to province.
     */
    public function province()
    {
        return $this->belongsTo(Province::class)->withDefault();;
    }

    /**
     * Get full attributes.
     */
    public function getFullAttribute()
    {
        return join(', ', [$this->name, $this->province->name]);
    }
}
