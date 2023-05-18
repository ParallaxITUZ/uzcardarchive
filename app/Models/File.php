<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class File extends Model
{
    use HasFactory;

    public const TEMP = 1;

    protected $fillable = [
        'user_id',
        'type',
        'filename',
        'path',
        'extension',
        'size',
    ];
}
