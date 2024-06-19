<?php

namespace Modules\Event\Models;

use App\Models\Traits\Restorable\Restorable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable\Searchable;

class InvoiceTransaction extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = "invoice_transactions";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice_id', 'code', 'payer', 'receipt', 'method', 'paid_amount', 'paid_at', 'validated_at'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'meta' => 'object'
    ];


    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at', 'paid_at', 'validated_at'
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'name'
    ];

    /**
     * This belongs to invoice.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
