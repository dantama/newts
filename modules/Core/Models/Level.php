<?php

namespace Modules\Core\Models;

use App\Enums\LevelTypeEnum;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use Restorable, Searchable;
    /**
     * The table associated with the model.
     */
    protected $table = 'org_levels';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'type', 'kd', 'name', 'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'type' => LevelTypeEnum::class
    ];
}
