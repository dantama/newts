<?php

namespace Modules\Core\Models;

use Modules\Core\Models\Position;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = 'departements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kd',
        'name',
        'description',
        'parent_id',
        'is_visible',
        'is_addable',
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

    public function unit_departement()
    {
        return $this->hasMany(UnitDepartement::class, 'dept_id');
    }
}
