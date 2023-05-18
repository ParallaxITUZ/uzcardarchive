<?php

namespace App\Models;

use App\Services\LangService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(mixed $country)
 * @method static create(array $array)
 */
class DictionaryItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'display_name',
        'dictionary_id',
        'parent_id',
        'order',
        'description',
        'value',
        'is_deleted',
    ];

    protected $primaryKey = 'id';

    protected $casts = [
        'display_name' => 'array',
        'description' => 'array',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function dictionary(){
        return $this->belongsTo(Dictionary::class, 'dictionary_id', 'id');
    }

    public function parentItem(){
        return $this->belongsTo(DictionaryItem::class, 'parent_id', 'id');
    }

    public function items(){
        return $this->hasMany(DictionaryItem::class, 'parent_id');
    }

    public function tarifConfs(){
        return $this->hasMany(ProductTariffConfiguration::class, 'dictionary_item_id');
    }

    public function getDisplayNameAttribute($value)
    {
        return LangService::getLocaled($value, app()->getLocale());
    }

    public function getDescriptionAttribute($value)
    {
        return LangService::getLocaled($value, app()->getLocale());
    }
}
