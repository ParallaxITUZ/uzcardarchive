<?php

namespace App\DataObjects\PolicyRequest;

use App\DataObjects\BaseDataObject;

class PolicyRequestDataObject extends BaseDataObject
{
    public $id;
    public $sender_id;
    public $sender;
    public $receiver_id;
    public $receiver;
    public $requested_user_id;
    public $requested_user;
    public $approved_user_id;
    public $approved_user;
    public $status;
    public $delivery_date;
    public $comment;
    public $items;
}
