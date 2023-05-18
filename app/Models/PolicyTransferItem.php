<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyTransferItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'policy_transfer_id',
        'from_warehouse_item_id',
        'to_warehouse_item_id',
        'policy_id',
        'series',
        'number_from',
        'number_to',
        'axo_user_id',
        'request_item_id',
        'amount',
        'type',
        'status',
    ];

    public function fromWarehouse(){
        return $this->belongsTo(WarehouseItem::class, 'from_warehouse_item_id', 'id');
    }
    public function toWarehouse(){
        return $this->belongsTo(WarehouseItem::class, 'to_warehouse_item_id', 'id');
    }
    public function policy(){
        return $this->belongsTo(Policy::class, 'policy_id', 'id');
    }
    public function axo(){
        return $this->belongsTo(User::class, 'axo_user_id', 'id');
    }
    public function requestItem(){
        return $this->belongsTo(PolicyRequestItem::class, 'request_item_id', 'id');
    }
    public function transfer(){
        return $this->belongsTo(PolicyTransfer::class, 'request_item_id', 'id');
    }
}
