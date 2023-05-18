<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseItem extends Model
{
    use HasFactory;

    public const FOND = 0;

    public const STATUS_PASSIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'warehouse_id',
        'policy_id',
        'series',
        'number_from',
        'number_to',
        'amount',
        'status',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function policy(){
        return $this->belongsTo(Policy::class, 'warehouse_id', 'id');
    }

    public function send(){
        return $this->hasOne(PolicyTransferItem::class, 'from_warehouse_item_id', 'id');
    }

    public function receive(){
        return $this->hasOne(PolicyTransferItem::class, 'to_warehouse_item_id', 'id');
    }
}
