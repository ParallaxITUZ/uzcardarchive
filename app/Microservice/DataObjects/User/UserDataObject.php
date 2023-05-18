<?php

namespace App\Microservice\DataObjects\User;

use App\DataObjects\BaseDataObject;

class UserDataObject extends BaseDataObject
{
    public $phone;
    public $entity_type_id = 15;
    public $client_id;
}
