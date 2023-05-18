<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualClientData extends Model
{
    use HasFactory;

    protected $table = 'individual_client_datas';

    protected $fillable = [
        "client_id",
        "first_name",
        "last_name",
        "pinfl",
        "middle_name",
        "passport_seria",
        "passport_number",
        "birthday",
        "gender",
        "region_id",
        "district_id",
    ];

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * @param $value
     * @return void
     */
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = Carbon::parse($value)->format('m.d.Y');
    }
}
