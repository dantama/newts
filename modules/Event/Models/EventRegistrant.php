<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventRegistrant extends Model
{
    use SoftDeletes;

    protected $table = "event_registrants";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'event_id', 'user_id', 'level_id', 'kd', 'refid', 'file', 'passed_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'event_id', 'user_id', 'level_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'passed_at', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * This belongs to user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * This belongs to level.
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
}
