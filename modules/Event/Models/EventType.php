<?php

namespace Modules\Event\Models;

use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use Searchable;

    protected $table = "event_categories";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title', 'kd', 'description'
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
     * search.
     */
    protected $search = ['title'];

    /**
     * This has many events.
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'type_id');
    }
}
