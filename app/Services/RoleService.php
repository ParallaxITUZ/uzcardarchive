<?php

namespace App\Services;

use App\ActionData\Role\RoleActionData;
use App\ActionResults\CommonActionResult;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\Role\RoleDataObject;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Structures\RpcErrors;

class RoleService {

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(RoleActionData $action_data): CommonActionResult {
        $action_data->validate();
        $role = Role::query()->create([
            'name' => $action_data->name,
            'display_name' => $action_data->display_name,
            'description' => $action_data->description
        ]);
        $role->attachPermissions($action_data->permissions);

        return new CommonActionResult($role->id);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(RoleActionData $action_data){
        $action_data->validate();
        $role = Role::query()->where('id', $action_data->id)->first();
        $role->update([
            'name' => $action_data->name,
            'display_name' => $action_data->display_name,
            'description' => $action_data->description
        ]);
        $role->detachPermissions(Permission::all());
        $role->attachPermissions($action_data->permissions);
        $role = $this->get($role->id);
        return new CommonActionResult($role->id);
    }

    public function delete(int $id){
        try {
            $role = Role::query()->findOrFail($id);
            $role->detachPermissions(Permission::all());
            if ($role->delete()){
                return new CommonActionResult($id);
            } else {
                return (new CommonActionResult(0))->setError(RpcErrors::FORBIDDEN_TEXT, RpcErrors::FORBIDDEN_CODE);
            }
        }catch (\Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), -32000-($e->getCode()));
        }
    }

    public function get(int $id){
        try {
            $role = Role::query()->findOrFail($id);
            $view = new RoleDataObject($role->toArray());
            $view->permissions = $role->permissions;
            return $view;
        }catch (\Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), -32000-($e->getCode()));
        }
    }

    public function getFullData(int $id){
        try {
            $role = Role::query()->findOrFail($id);
            $view = new RoleDataObject($role->toArray());
            $view->display_name = json_decode($role->getRawOriginal('display_name'));
            $view->description = json_decode($role->getRawOriginal('description'));
            $view->permissions = $role->permissions;
            return $view;
        }catch (\Exception $e){
            return (new CommonActionResult(0))->setError($e->getMessage(), -32000-($e->getCode()));
        }
    }

    public function paginate($page = 1, $limit = 25, ?iterable $filters = null){
        $roles = Role::query()->latest()->paginate($limit);
        $items = $roles->getCollection()->transform(function ($item){
            return new RoleDataObject($item->toArray());
        });
        return new DataObjectPagination($items, $roles->total(), $limit, $page);
    }
}
