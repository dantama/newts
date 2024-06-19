<?php

namespace Modules\Core\Models;

use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Model;

class ManagerContract extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = 'manager_contracts';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'manager_id', 'contract_id', 'start_at', 'end_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The relations to eager load on every query.
     */
    public $with = [
        'detail'
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [];

    /**
     * This belongsTo member.
     */
    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id')->withDefault();
    }


    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
