<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $entity_type_id
 * @property mixed $individual
 * @property mixed $legal
 */
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_type_id',
        'address',
        'phone',
        'registered_user_id',
    ];

    public function individual(){
        return $this->hasOne(IndividualClientData::class);
    }

    public function legal(){
        return $this->hasOne(LegalClientData::class);
    }

    public function data()
    {
        if ($this->entity_type_id == 15) {
            return $this->individual;
        }
        return $this->legal;
    }
}
