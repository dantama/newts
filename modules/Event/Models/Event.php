<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Approvable\Approvable;
use App\Models\Traits\Documentable\Documentable;
use App\Models\Traits\Metable\Metable;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Modules\Account\Models\User;

class Event extends Model
{
    use Restorable, Searchable, Metable, Approvable, Documentable;

    protected $table = "events";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'author_id', 'title', 'slug', 'content', 'event_ctg_id', 'price', 'start_at', 'end_at', 'registerable', 'attachment'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'start_at', 'end_at', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'start_at' => 'datetime', 'end_at' => 'datetime', 'deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'
    ];

    /**
     * The relations to eager load on every query.
     */
    public $with = [];

    protected $appends = [];

    /**
     * This belongs type.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id')->withDefault();
    }

    /**
     * This belongs type.
     */
    public function type()
    {
        return $this->belongsTo(EventType::class, 'event_ctg_id');
    }

    /**
     * This has many registrants through exam.
     */
    public function registrants()
    {
        return $this->hasMany(EventRegistrant::class, 'event_id');
    }

    /**
     * This time range.
     */
    public function timeRange()
    {
        if ($this->start_at && $this->end_at) {
            return join(' - ', [$this->start_at->ISOFormat('ll'), $this->end_at->ISOFormat('ll')]);
        }
        return null;
    }
}
