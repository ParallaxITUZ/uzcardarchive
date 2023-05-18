<?php

namespace App\DataObjects\File;

use App\DataObjects\BaseDataObject;

class FileDataObject extends BaseDataObject
{
    public $id;
    public $user;
    public $user_id;
    public $filename;
    public $path;
    public $extension;
    public $type;
    public $size;
}
