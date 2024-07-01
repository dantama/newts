<?php

namespace Modules\Blog\Models;

use App\Models\Traits\Restorable\Restorable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable\Searchable;
use Modules\Account\Models\User;

class Template extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = "page_templates";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'slug', 'title', 'content', 'author_id', 'visibled', 'published_at', 'approved'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'meta' => 'object',
        'deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'published_at' => 'datetime'
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'title', 'content'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id')->withDefault();
    }
}
