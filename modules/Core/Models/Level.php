<?php

namespace Modules\Core\Models;

use App\Enums\LevelTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
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
