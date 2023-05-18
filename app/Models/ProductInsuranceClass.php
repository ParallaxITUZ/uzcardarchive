<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInsuranceClass extends Model
{
    use HasFactory;

    protected $table = 'product_insurance_classes';

    protected $fillable = [
        'product_id',
        'insurance_class_id',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function insuranceClass(){
        return $this->belongsTo(DictionaryItem::class, 'insurance_class_id', 'id');
    }
}
