<?php

namespace App\DataObjects\Import;

use App\DataObjects\BaseDataObject;

class ImportDataObject extends BaseDataObject
{
    public $id;
    public $policy_id;
    public $series;
    public $number_from;
    public $number_to;
    public $applicant_id;
    public $timestamps;
}
