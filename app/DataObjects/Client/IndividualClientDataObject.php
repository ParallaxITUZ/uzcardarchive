<?php

namespace App\DataObjects\Client;

use App\DataObjects\BaseDataObject;

class IndividualClientDataObject extends BaseDataObject
{
    public $address;
    public $phone;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $passport_seria;
    public $passport_number;
    public $registered_user_id;
}
