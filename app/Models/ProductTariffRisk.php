<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTariffRisk extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_tariff_id',
        'name',
        'amount',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function tariff(){
        return $this->belongsTo(ProductTariff::class, 'product_tariff_id', 'id');
    }
}
