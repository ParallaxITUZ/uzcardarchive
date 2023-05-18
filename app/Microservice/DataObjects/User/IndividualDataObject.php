<?php

namespace App\Microservice\DataObjects\User;

use App\DataObjects\BaseDataObject;

class IndividualDataObject extends BaseDataObject
{
    public $client_id;
    public $birthday;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $passport_seria;
    public $passport_number;
}
