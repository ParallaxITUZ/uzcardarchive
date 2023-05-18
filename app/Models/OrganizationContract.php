<?php

namespace App\Models;

use App\Services\LangService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationContract extends Model
{
    use HasFactory;

    public const STATUS_PASSIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'organization_id',
        'user_id',
        'file_id',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
