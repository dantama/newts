<?php

namespace Modules\Reference\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Cacheable\Cacheable;
use App\Models\Traits\Searchable\Searchable;

class Software extends Model
{
    use Cacheable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = "ref_softwares";

    /* *
     * fillable column
     */
    protected $fillable = [
        'platform', 'software', 'code'
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'platform', 'software',
    ];

    /**
     * Scope find by code.
     */
    public function scopeFindByCode($query, string $code)
    {
        return $query->whereCode($code)->first();
    }

    /**
     * Scope find by code or fail.
     */
    public function scopeFindByCodeOrFail($query, string $code)
    {
        return $query->whereCode($code)->firstOrFail();
    }
}
