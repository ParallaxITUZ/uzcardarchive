<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentData extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'organization_id';
    protected $table = 'agent_datas';

    protected $fillable = [
        'organization_id',
        'agent_type_id',
        'pinfl',
    ];

    public function agentType(){
        return $this->belongsTo(DictionaryItem::class, 'agent_type_id', 'id');
    }

    public function organization(){
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
