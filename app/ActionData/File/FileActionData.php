<?php

namespace App\ActionData\File;

use App\ActionData\ActionDataBase;

class FileActionData extends ActionDataBase
{
    public $file;

    protected array $rules = [
        "file" => "required|file"
    ];
}
