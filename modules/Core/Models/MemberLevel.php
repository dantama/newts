<?php

namespace Modules\Core\Models;

use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class MemberLevel extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = 'member_levels';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'member_id', 'level_id', 'year', 'meta'
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
    public $casts = [
        'meta' => 'array'
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


    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
}
