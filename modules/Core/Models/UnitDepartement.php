<?php

namespace Modules\Core\Models;

use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class UnitDepartement extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = 'unit_departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kd',
        'organization_id',
        'dept_id',
        'description',
        'parent_id',
        'is_visible',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * belongs to departement.
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'dept_id');
    }

    /**
     * belongs to organization.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function unit_positions()
    {
        return $this->hasMany(UnitPosition::class, 'unit_dept_id');
    }
}
