<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'old_contract_id',
        'new_contract_id',
        'reason_id',
        'comment',
    ];


    public function oldContract()
    {
        return $this->hasOne(ClientContract::class, 'id', 'old_contract_id');
    }

    public function newContract()
    {
        return $this->hasOne(ClientContract::class, 'id', 'new_contract_id');
    }

    public function reason()
    {
        return $this->hasOne(DictionaryItem::class, 'id', 'reason_id');
    }
}
