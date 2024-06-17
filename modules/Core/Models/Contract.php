<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use App\Models\Traits\Metable\Metable;

class Contract extends Model
{
    use Restorable, Searchable, Metable;

    /**
     * The table associated with the model.
     */
    protected $table = 'contracts';

    /**
     * Define the meta table
     */
    public $metaTable = 'contract_meta';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kd', 'name', 'description'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'kd', 'name'
    ];
}
