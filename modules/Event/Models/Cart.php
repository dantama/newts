<?php

namespace Modules\Event\Models;

use App\Models\Traits\Restorable\Restorable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable\Searchable;
use Modules\Account\Models\User;

class Cart extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = "carts";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'itemable_type', 'itemable_id', 'meta'
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
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'name'
    ];

    /**
     * This belongs to user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * This morph to itemable.
     */
    public function itemable()
    {
        return $this->morphTo();
    }
}
