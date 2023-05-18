<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTariffConfiguration extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_PASSIVE = 0;

    protected $fillable = [
        'product_tariff_id',
        'dictionary_item_id',
        'option_from',
        'option_to',
        'value',
        'status',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function productTariff(){
        return $this->belongsTo(ProductTariff::class, 'product_tariff_id', 'id');
    }

    public function dictionaryItem(){
        return $this->belongsTo(DictionaryItem::class, 'dictionary_item_id', 'id');
    }
}
