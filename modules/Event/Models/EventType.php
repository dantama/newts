<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $table = "event_categories";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'description'
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
     * This has many events.
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'type_id');
    }
}
