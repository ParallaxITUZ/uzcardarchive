<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'dictionary_insurance_object_id',
        'insurance_form_id',
        'insurance_type_id',
        'period_type_id',
        'currency_id',
        'single_payment',
        'multi_payment',
        'tariff_scale_from',
        'tariff_scale_to',
        'policy_id',
        'status',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function insuranceObject(){
        return $this->hasOne(DictionaryItem::class, 'id', 'dictionary_insurance_object_id');
    }

    public function insuranceForm(){
        return $this->hasOne(DictionaryItem::class, 'id', 'insurance_form_id');
    }

    public function insuranceType(){
        return $this->hasOne(DictionaryItem::class, 'id', 'insurance_type_id');
    }

    public function periodType(){
        return $this->hasOne(DictionaryItem::class, 'id', 'period_type_id');
    }

    public function currency(){
        return $this->belongsTo(DictionaryItem::class, 'currency_id', 'id');
    }

    public function insuranceClasses(){
        return $this->belongsToMany(DictionaryItem::class, 'product_insurance_classes', 'product_id', 'insurance_class_id');
    }

    public function periods(){
        return $this->hasMany(ProductPeriod::class);
    }

    public function policy(){
        return $this->belongsTo(Policy::class, 'policy_id', 'id');
    }
}
