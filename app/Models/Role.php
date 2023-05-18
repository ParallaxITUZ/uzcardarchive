<?php

namespace App\Models;

use App\Services\LangService;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
//    protected $casts = [
//        'display_name' => 'array',
//        'description' => 'array',
//    ];

    public $guarded = [];

//    public function getDisplayNameAttribute($value)
//    {
//        return LangService::getLocaled($value, app()->getLocale());
//    }
//
//    public function getDescriptionAttribute($value)
//    {
//        return LangService::getLocaled($value, app()->getLocale());
//    }
}
