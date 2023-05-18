<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @method static findOrFail($invoice_id)
 */
class Invoice extends Model
{
    use HasFactory;

    public const CANCELED = 0;
    public const NOT_PAID = 1;
    public const PAID = 2;

    protected $fillable = [
        'contract_id',
        'series',
        'number',
        'amount',
        'status',
    ];

    public function payment(){
        return $this->hasOne(Payment::class, 'invoice_id', 'id');
    }

    public function contract(){
        return $this->belongsTo(ClientContract::class, 'contract_id', 'id');
    }

    /**
     * @return MorphTo
     */
    public function invoiceable(): MorphTo
    {
        return $this->morphTo();
    }
}
