<?php

namespace App\Models;

use App\Services\LangService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Dictionary extends Model
{
    use HasFactory;

    public const REGIONS = 'regions';
    public const AGENT_TYPES = 'agent_types';
    public const ORGANIZATIONAL_STRUCTURE_TYPES = 'organizations';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'display_name',
        'is_deleted',
    ];
    protected $casts = [
        'display_name' => 'array',
    ];
    protected $hidden = [
        'is_deleted'
    ];

    public function items(){
        return $this->hasMany(DictionaryItem::class);
    }

    public function getDisplayNameAttribute($value)
    {
        return LangService::getLocaled($value, app()->getLocale());
    }
}
