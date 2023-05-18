<?php

namespace App\DataObjects\User;

use App\DataObjects\BaseDataObject;
use App\DataObjects\DataObjectContract;

class UserDataObject extends BaseDataObject implements DataObjectContract
{
    public $id;
    public $login;
    public $name;
    public $organization;
    public $position;
    public $phone;
    public $region;
    public $address;
    public $pinfl;
    public $roles;
    public $status;
    public $created_at;
}
