<?php

namespace App\DataObjects\Organization;

use App\DataObjects\BaseDataObject;

class AgentDataObject extends BaseDataObject
{
    public $id;
    public $name;
    public $products;
    public $region;
    public $region_id;
    public $parent;
    public $parent_id;
    public $agent_type;
    public $agent_type_id;
    public $organization_type_id;
    public $organization_type;
    public $company_number;
    public $filial_number;
    public $branch_number;
    public $agent_number;
    public $sub_agent_number;
    public $deposit_number;
    public $inn;
    public $pinfl;
    public $commission;
    public $account;
    public $address;
    public $director_fio;
    public $director_phone;
}
