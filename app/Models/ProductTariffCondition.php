<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTariffCondition extends Model
{
    use HasFactory;

    protected $fillable = [
        'dictionary_item_id',
        'product_tariff_id',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function dictionaryItem(){
        return $this->belongsTo(DictionaryItem::class, 'dictionary_item_id', 'id');
    }

    public function productTariff(){
        return $this->belongsTo(ProductTariff::class, 'product_tariff_id', 'id');
    }
}
