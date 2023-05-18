<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractPolicy extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'contract_id',
        'series',
        'number',
        'status',
        'is_deleted'
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function contract(){
        return $this->belongsTo(ClientContract::class, 'contract_id', 'id');
    }
}
