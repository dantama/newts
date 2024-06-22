<?php

namespace Modules\Blog\Models;

use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use Restorable, Searchable;

    /**
     * The database table used by the model.
     */
    protected $table = 'subscribers';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'id'
    ];

    protected $searchable = [
        'email'
    ];
}
