<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPeriod extends Model
{
    use HasFactory;

    protected $table = 'product_periods';

    protected $fillable = [
        'period_from',
        'period_to',
        'product_id',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
