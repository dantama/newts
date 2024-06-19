<?php

namespace Modules\Event\Models;

use App\Models\Traits\Restorable\Restorable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable\Searchable;
use Modules\Course\Models\Course;
use Modules\Course\Models\Workshop;

class InvoiceItem extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = "invoice_items";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_id', 'itemable_type', 'itemable_id', 'price', 'meta'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'meta' => 'object',
    ];


    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'invoice.code'
    ];

    public $appends = [
        'itemable_label'
    ];

    /**
     * This belongs to invoice.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    /**
     * This morph to itemable.
     */
    public function itemable()
    {
        return $this->morphTo();
    }

    /**
     * Get itemable_name
     */
    public function getItemableLabelAttribute()
    {
        return match ($this->itemable_type) {
            Course::class => 'Kelas',
            Workshop::class => 'Workshop',
            default => 'Item'
        };
    }
}
