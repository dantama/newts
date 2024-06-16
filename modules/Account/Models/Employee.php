<?php

namespace Modules\Account\Models;

use App\Models\Traits\Approvable\Approver;
use App\Models\Traits\Metable\Metable;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Modules\Account\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes, Approver, Searchable, Restorable, Metable;

    /**
     * The table associated with the model.
     */
    protected $table = 'employees';

    /**
     * Define the meta table
     */
    protected $metaTable = 'employee_meta';

    /**
     * Define the meta key name
     */
    public $metaKeyName = 'empl_id';

    /**
     * Prevent meta from being populated
     */
    public $hideMeta = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'joined_at',
        'permanent_at'
    ];

    protected $hidden = [
        'empower_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'joined_at' => 'datetime', 'permanent_at' => 'datetime'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * belongs to user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function position()
    {
        return $this->hasOne(EmployeePosition::class, 'empl_id')->active()->withDefault();
    }

    public function positions()
    {
        return $this->hasMany(EmployeePosition::class, 'empl_id');
    }

    /**
     * This has many contracts.
     */
    public function contracts()
    {
        return $this->hasMany(EmployeeContract::class, 'empl_id')->orderByDesc('start_at');
    }

    /**
     * This has many contract.
     */
    public function contract()
    {
        return $this->hasOne(EmployeeContract::class, 'empl_id')->active();
    }

    /**
     * When position of department.
     */
    public function scopeWhereDepartment($query, $dep)
    {
        return $query->when($dep, fn ($q) => $q->whereHas('position', fn ($dept) => $dept->where('dept_id', $dep)));
    }

    /**
     *  When position.
     */
    public function scopeWherePosition($query, $pos)
    {
        return $query->when($pos, fn ($q) => $q->where('position_id', $pos));
    }

    /**
     *  search where not in level.
     */
    public function scopeWhereNotInLevel($query, $lev)
    {
        return $query->when($lev, fn ($q) => $q->whereHas('position', fn ($p) => $p->whereNotIn('level', $lev)));
    }

    /**
     *  seach by level.
     */
    public function scopeWhereLevel($query, $lev)
    {
        return $query->when($lev, fn ($q) => $q->whereHas('position', fn ($p) => $p->where('level', $lev)));
    }
}
