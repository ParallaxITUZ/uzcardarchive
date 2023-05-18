<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalClientsData extends Model
{
    use HasFactory;

    protected $fillable = [
        "client_id",
        "name",
        "inn",
        "company",
        "activity_id",
        "okonx",
        "director_fish",
        "contact_name",
        "contact_phone"
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function activity(){
        return $this->belongsTo(DictionaryItem::class, 'activity_id', 'id');
    }
}
