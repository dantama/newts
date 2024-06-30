<?php

namespace Modules\Core\Models;

use App\Models\Traits\Metable\Metable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Modules\Account\Models\User;
use Modules\Core\Enums\MembershipTypeEnum;
use Modules\Core\Models\Traits\MemberTrait;

class Member extends Model
{
    use Restorable, Searchable, Metable, MemberTrait;

    /**
     * The table associated with the model.
     */
    protected $table = 'members';

    /**
     * Define the meta table
     */
    protected $metaTable = 'members_meta';

    /**
     * Define the meta key name
     */
    public $metaKeyName = 'member_id';

    /**
     * Prevent meta from being populated
     */
    public $hideMeta = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'unit_id', 'type', 'user_id', 'nbts', 'nbm', 'qr', 'joined_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'type' => MembershipTypeEnum::class
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [];

    /**
     * search by column or relation.
     */
    protected $searchable = [
        'user.name', 'level.level.name', 'nbts', 'nbm', 'user.email_address', 'unit.name'
    ];


    protected static function booted()
    {
        // 
    }

    /**
     * This belongsTo user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    /**
     * This belongsTo unit.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id')->withDefault();
    }

    /**
     * This hasMany levels.
     */
    public function level()
    {
        return $this->hasOne(MemberLevel::class, 'member_id')->latest();
    }

    /**
     * This hasMany levels.
     */
    public function levels()
    {
        return $this->hasMany(MemberLevel::class, 'member_id');
    }

    /**
     * This has one manager.
     */
    public function manager()
    {
        return $this->hasOne(Manager::class, 'member_id')->active();
    }

    /**
     * This has many manager.
     */
    public function managers()
    {
        return $this->hasMany(Manager::class, 'member_id');
    }

    /**
     * Scope where code in.
     */
    public function scopeWhenUnits($query, $units)
    {
        return $query->when($units, fn ($m) => $m->whereIn('unit_id', $units));
    }

    /**
     * Scope where code in.
     */
    public function scopeWhenType($query, $type)
    {
        return $query->when($type, fn ($m) => $m->whereType($type));
    }

    /**
     * Scope where code in.
     */
    public function scopeWhenLevelIn($query, array $level)
    {
        return $query->when($level, fn ($m) => $m->whereHas('level', fn ($l) => $l->whereIn('level_id', $level)));
    }

    /**
     * Scope where regency in.
     */
    public function scopeWhenRegencyIn($query, array $regency)
    {
        return $query->when($regency, fn ($m) => $m->whereHas('unit', fn ($u) => $u->whereMetaIn('org_regency_id', $regency)));
    }

    /**
     * Scope member is managerial.
     */
    public function scopeManagerial($query)
    {
        return $query->whereHas('manager')->with([
            'manager' => fn ($r) => $r->with(
                'unit_departement',
                'contract'
            )
        ])->first();
    }

    /**
     * Scope managerUnit.
     */
    public function scopeManagerUnit($query)
    {
        return $query->managerial()->manager->unit_departement->unit_id;
    }

    /**
     * Scope member is manager.
     */
    public function scopeIsManager($query): bool
    {
        return count($query->whereHas('manager')->get());
    }
}
