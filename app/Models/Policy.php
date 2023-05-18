<?php

namespace App\Models;

use App\Services\LangService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    public const FOND = 0;
    public const FOND_SERIES = "AA";

    public const STATUS_PASSIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'display_name',
        'series',
        'form',
        'status',
        'is_deleted',
    ];
    protected $casts = [
        'display_name' => 'array',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function getDisplayNameAttribute($value)
    {
        return LangService::getLocaled($value, app()->getLocale());
    }
}
