<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name',
        'region_id',
        'address',
        'pinfl',
        'phone',
        'user_id',
        'organization_id',
        'position_id',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function region(){
        return $this->belongsTo(DictionaryItem::class, 'region_id', 'id');
    }

    public function position(){
        return $this->belongsTo(DictionaryItem::class, 'position_id', 'id');
    }

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
