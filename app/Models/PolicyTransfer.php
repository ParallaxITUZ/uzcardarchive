<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyTransfer extends Model
{
    use HasFactory;

    public const STATUS_PASSIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'from_warehouse_id',
        'to_warehouse_id',
        'policy_request_id',
        'status',
    ];

    public function fromWarehouse(){
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id', 'id');
    }
    public function toWarehouse(){
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id', 'id');
    }
    public function policyRequest(){
        return $this->belongsTo(PolicyRequest::class, 'policy_request_id', 'id');
    }
    public function items(){
        return $this->hasMany(PolicyTransferItem::class, 'policy_transfer_id', 'id');
    }
}
