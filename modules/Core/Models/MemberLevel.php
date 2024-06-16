<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MemberLevel extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'ts_member_levels';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'member_id', 'level_id', 'year'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The relations to eager load on every query.
     */
    public $with = [
        'detail'
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [];

    /**
     * This belongsTo member.
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id')->withDefault();
    }

    /**
     * This belongsTo regency.
     */
    public function regency()
    {
        return $this->belongsTo(ManagementRegency::class, 'regency_id')->withDefault();
    }

    public function detail()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function scopeGroupByLatestLevel()
    {
        return $this->selectRaw('level_id, COUNT(*) as members_count')
            ->from(function ($query) {
                $query->selectRaw('member_id, MAX(level_id) as level_id')->from($this->table)->groupBy('member_id');
            }, $this->table)
            ->withTrashed()
            ->groupBy('level_id');
    }
}
