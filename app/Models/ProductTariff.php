<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTariff extends Model
{
    use HasFactory;

    public const STATUS_PASSIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'name',
        'description',
        'product_id',
        'status',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function conditions(){
        return $this->hasMany(ProductTariffCondition::class, 'product_tariff_id');
    }

    public function risks(){
        return $this->hasMany(ProductTariffRisk::class, 'product_tariff_id');
    }
}
