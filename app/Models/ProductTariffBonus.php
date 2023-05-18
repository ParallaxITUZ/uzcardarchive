<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTariffBonus extends Model
{
    use HasFactory;

    public const STATUS_PASSIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'product_tariff_condition_id',
        'dictionary_item_id',
        'name',
        'value',
        'status',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function productTariffCondition(){
        return $this->belongsTo(ProductTariffCondition::class, 'product_tariff_condition_id', 'id');
    }

    public function dictionaryItem(){
        return $this->belongsTo(DictionaryItem::class, 'dictionary_item_id', 'id');
    }
}
