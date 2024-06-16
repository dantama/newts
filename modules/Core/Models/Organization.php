<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    protected $table = "organizations";

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
