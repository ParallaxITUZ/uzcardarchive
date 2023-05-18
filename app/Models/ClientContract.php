<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @method static expired()
 */
class ClientContract extends Model
{
    use HasFactory;

    public const STATUS_DENIED = 0;
    public const STATUS_PENDING = 1;
    public const STATUS_ACTIVE = 2;

    public const PRODUCT_TRAVEL = 1;
    public const PRODUCT_OSAGO = 2;

    protected $fillable = [
        'product_id',
        'product_tariff_id',
        'series',
        'number',
        'begin_date',
        'end_date',
        'configurations',
        'client_id',
        'objects',
        'amount',
        'risks_sum',
        'file_id',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'configurations' => 'array',
        'objects' => 'array',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function tariff(): BelongsTo
    {
        return $this->belongsTo(ProductTariff::class, 'product_tariff_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * @return MorphOne
     */
    public function invoice(): MorphOne
    {
        return $this->morphOne(Invoice::class, 'invoiceable');
    }

    /**
     * @return HasOne
     */
    public function file(): HasOne
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    /**
     * @return HasMany
     */
    public function contractPolicies(): HasMany
    {
        return $this->hasMany(ContractPolicy::class, 'contract_id', 'id');
    }

    /**
     * @param $val
     * @return void
     */
    public function setBeginDateAttribute($val)
    {
        $this->attributes['begin_date'] = Carbon::parse($val)->format('m.d.Y');
    }

    /**
     * @param $val
     * @return void
     */
    public function setEndDateAttribute($val)
    {
        $this->attributes['end_date'] = Carbon::parse($val)->format('m.d.Y');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('end_date', '<=', now());
    }
}
