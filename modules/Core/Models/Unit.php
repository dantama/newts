<?php

namespace Modules\Core\Models;

use App\Models\Traits\Metable\Metable;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use Restorable, Searchable, Metable;

    /**
     * Define the table
     */
    protected $table = "units";

    /**
     * Define the meta table
     */
    protected $metaTable = 'units_meta';

    /**
     * Define the meta key name
     */
    public $metaKeyName = 'unit_id';

    /**
     * Prevent meta from being populated
     */
    public $hideMeta = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kd', 'type', 'name', 'parent_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This has many provinces.
     * Punya banyak kepengurusan wilayah.
     */
    /**
     * This belongs to many parents.
     */
    public function parents()
    {
        return $this->belongsToMany(self::class, 'unit_trees', 'unit_id', 'parent_id')->orderBy('level');
    }

    /**
     * This belongs to many children.
     */
    public function children()
    {
        return $this->belongsToMany(self::class, 'unit_trees', 'parent_id', 'unit_id')->orderBy('level');
    }

    /**
     * This has many unit dept.
     */
    public function unit_depts()
    {
        return $this->hasMany(UnitDepartement::class, 'unit_id');
    }
}
