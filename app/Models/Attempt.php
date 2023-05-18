<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    use HasFactory;

    public const NOT_DONE = 0;
    public const DONE = 1;

    protected $fillable = [
        'user_id',
        'step',
        'form_data',
        'status',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
