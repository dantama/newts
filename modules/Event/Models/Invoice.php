<?php

namespace Modules\Event\Models;

use App\Models\Traits\Restorable\Restorable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable\Searchable;
use Modules\Account\Models\User;

class Invoice extends Model
{
    use Restorable, Searchable;

    /**
     * The table associated with the model.
     */
    protected $table = "invoices";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'code', 'final_price', 'due_at', 'paid_off_at', 'meta'
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
        'due_at', 'paid_off_at', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'user.name', 'code'
    ];

    /**
     * This belongs to user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get pretest badge html.
     */
    public function badge()
    {
        return $this->paid_off_at
            ? '<div class="badge bg-soft-success text-success fw-normal"><i class="mdi mdi-check"></i> Lunas</div>'
            : '<div class="badge bg-soft-danger text-danger fw-normal"><i class="mdi mdi-close"></i> Belum lunas</div>';
    }

    /**
     * This has many items.
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    /**
     * This has many transactions.
     */
    public function transactions()
    {
        return $this->hasMany(InvoiceTransaction::class, 'invoice_id');
    }
}
