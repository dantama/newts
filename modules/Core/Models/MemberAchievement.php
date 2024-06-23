<?php

namespace Modules\Core\Models;

use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class MemberAchievement extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = 'member_achievements';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'member_id', 'achievement_id', 'modelable_type', 'bodelable_id', 'label', 'start_at', 'end_at', 'meta'
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
    public $with = [];

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


    public function achievement()
    {
        // return $this->belongsTo(Level::class, 'level_id');
    }

    public function modelable()
    {
        return $this->morphTo();
    }
}
