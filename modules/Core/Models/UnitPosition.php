<?php

namespace Modules\Core\Models;

use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class UnitPosition extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = 'unit_positions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'org_dept_id',
        'position_id',
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
    public function unit_departement()
    {
        return $this->belongsTo(UnitDepartement::class, 'unit_dept_id');
    }

    /**
     * belongs to organization.
     */
    public function positions()
    {
        return $this->hasMany(Position::class, 'position_id');
    }
}
