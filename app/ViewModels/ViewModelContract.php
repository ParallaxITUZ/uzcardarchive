<?php

namespace App\ViewModels;

interface ViewModelContract
{
    public function toView(string $view_name);
}
