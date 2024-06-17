<?php

namespace Modules\Core\Models;

use App\Models\Traits\Metable\Metable;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use Restorable, Searchable, Metable;

    protected $table = "organizations";

    /**
     * Define the meta table
     */
    protected $metaTable = 'organizations_meta';

    /**
     * Define the meta key name
     */
    public $metaKeyName = 'organization_id';

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
        return $this->belongsToMany(self::class, 'org_trees', 'organization_id', 'parent_id')->orderBy('level');
    }

    /**
     * This belongs to many children.
     */
    public function children()
    {
        return $this->belongsToMany(self::class, 'org_trees', 'parent_id', 'organization_id')->orderBy('level');
    }
}
