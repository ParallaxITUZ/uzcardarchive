<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyRequestItem extends Model
{
    use HasFactory;

    public const IMPORT = 0;

    public const STATUS_PASSIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'policy_request_id',
        'policy_id',
        'amount',
        'approved_amount',
        'status',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function policyRequest(){
        return $this->belongsTo(PolicyRequest::class, 'policy_request_id', 'id');
    }

    public function policy(){
        return $this->belongsTo(Policy::class, 'policy_id', 'id');
    }
}
