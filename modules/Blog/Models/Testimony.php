<?php

namespace Modules\Blog\Models;

use App\Models\Traits\Restorable\Restorable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable\Searchable;

class Testimony extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = "testimonies";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'content', 'meta'
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
        'deleted_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'name', 'content'
    ];
}
