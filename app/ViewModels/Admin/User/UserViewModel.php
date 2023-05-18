<?php

namespace App\ViewModels\Admin\User;

use App\ViewModels\BaseViewModel;
use App\ViewModels\ViewModelContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserViewModel extends BaseViewModel implements ViewModelContract
{
    public $id;
    public $name;
    public $login;
    public $status;
    public $role;
    public $created_at;
    public $status_class;
    public $status_name;

    protected function populate()
    {
        $this->status_class = $this->status === 10 ? "success" : "danger";
        if ($this->status === 10){
            $this->status_name = trans('auth.status_active');
        } elseif ($this->status === 0){
            $this->status_name = trans('auth.status_deleted');
        } else {
            $this->status_name = trans('auth.status_inactive');
        }
        $this->created_at = Carbon::parse($this->created_at)->format('d F, Y');
    }

    public function getPermissionsList()
    {
        return Auth::user()->allPermissions();
    }
}
