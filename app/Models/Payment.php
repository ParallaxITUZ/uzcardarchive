<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const RETURNED = 0;
    public const PAID = 1;

    public const CASH = 1;
    public const CARD = 2;

    public const UZS = 1;
    public const USD = 2;

    protected $fillable = [
        'invoice_id',
        'amount',
        'type',
        'currency',
        'comment',
        'status',
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
