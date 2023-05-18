<?php

namespace App\Models;

use App\Services\LangService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory;

    public const FOND = 0;
    public const KAFOLAT = 1;

    public const STATUS_PASSIVE = 0;
    public const NOT_CONFIRMED = 9;
    public const STATUS_ACTIVE = 10;

    public const ENTITY_TYPE_FIZ = 15;
    public const ENTITY_TYPE_YUR = 16;

    public const COMPANY = 17;
    public const FILIAL = 18;
    public const CENTRE = 19;
    public const DEPARTMENT = 20;
    public const AGENT = 21;
    public const WORKER = 22;
    public const SUB_AGENT = 23;

    public const AGENT_TYPE_FIZ = 28;
    public const AGENT_TYPE_YUR = 29;
    public const AGENT_TYPE_COMPANY = 30;
    public const AGENT_TYPE_SUB = 31;

    protected $fillable = [
        'name',
        'region_id',
        'parent_id',
        'organization_type_id',
        'company_number',
        'filial_number',
        'branch_number',
        'agent_number',
        'sub_agent_number',
        'inn',
        'account',
        'address',
        'director_fio',
        'director_phone',
        'status',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];

    public function region(){
        return $this->belongsTo(DictionaryItem::class, 'region_id', 'id');
    }

    public function parent(){
        return $this->belongsTo(Organization::class, 'parent_id', 'id');
    }

    public function organizationType(){
        return $this->belongsTo(DictionaryItem::class, 'organization_type_id', 'id');
    }

    public function organizationContract(){
        return $this->belongsTo(OrganizationContract::class, 'id', 'organization_id');
    }

    public function agentContract(){
        return $this->belongsTo(AgentContract::class, 'id', 'organization_id');
    }

    public function agentData(){
        return $this->belongsTo(AgentData::class, 'id', 'organization_id');
    }

    public function agentProducts(){
        return $this->belongsToMany(Product::class, 'agent_products', 'agent_id');
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'id', 'organization_id');
    }

    public function getNameAttribute($value)
    {
        return LangService::getLocaled($value, app()->getLocale());
    }
}
