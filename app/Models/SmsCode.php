<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class SmsCode extends Model
{
    use HasFactory;

    protected $guarded = [''];
}
