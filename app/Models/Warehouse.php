<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    public const FOND = 0;
    public const KAFOLAT = 1;

    public const STATUS_PASSIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'organization_id',
        'status',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function items(){
        return $this->hasMany(WarehouseItem::class);
    }

}
