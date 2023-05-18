<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyRequest extends Model
{
    use HasFactory;

    public const IMPORT = 0;

    public const CREATED = 0;
    public const VIEWED = 1;
    public const WORKING = 2;
    public const PARTLY_COMPLETED = 3;
    public const COMPLETED = 4;
    public const DONE = 5;
    public const REJECTED = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'requested_user_id',
        'approved_user_id',
        'status',
        'delivery_date',
        'comment',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function items(){
        return $this->hasMany(PolicyRequestItem::class);
    }

    public function receiver(){
        return $this->belongsTo(Organization::class, 'receiver_id', 'id');
    }

    public function sender(){
        return $this->belongsTo(Organization::class, 'sender_id', 'id');
    }

    public function requester(){
        return $this->belongsTo(User::class, 'requested_user_id', 'id');
    }

    public function approver(){
        return $this->belongsTo(User::class, 'approved_user_id', 'id');
    }
}
