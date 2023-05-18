<?php

namespace App\ViewModels\Admin\User;

use App\DataObjects\User\RoleData;
use App\Models\File\PermissionModel;
use App\ViewModels\BaseViewModel;

class RoleViewModel extends BaseViewModel
{
    public $id;
    public $name;
    public $display_name;
    public $description;
    public $system;
    /**
     * @var array
     */
    public $permissions = [];
    /**
     * @var RoleData
     */
    protected $_data;

    protected function populate()
    {
        /* $this->status_class = $this->_data->status === 1 ? "success" : "danger";
         $this->status_name = $this->_data->status === 1 ? trans('all.status_active') : trans('all.status_inactive');
         $this->created_at = Carbon::parse($this->_data->created_at)->format(SettingsService::getDefaultCarbonDateTimeFormat());
         $this->full_name = $this->l_name . ' ' . $this->f_name;*/
    }

    public function getPermissionsList()
    {
        return PermissionModel::all();
    }
}
