<?php

namespace App\Services;

use App\ActionData\Permission\PermissionActionData;
use App\ActionData\Permission\PermissionUpdateActionData;
use App\ActionResults\CommonActionResult;
use App\ActionResults\VoidActionResult;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\Permission\PermissionDataObject;
use App\Models\Permission;

class PermissionService {
    /**
     * @param PermissionActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(PermissionActionData $action_data): CommonActionResult {
        $action_data->validate();
        $permission = Permission::query()->create([
            'name' => $action_data->name,
            'display_name' => $action_data->display_name,
            'description' => $action_data->description
        ]);
        return new CommonActionResult($permission->id);
    }

    /**
     * @param PermissionUpdateActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(PermissionUpdateActionData $action_data){
        $action_data->validate();
        $permission = Permission::query()->findOrFail($action_data->id);
        $permission->update([
            'name' => $action_data->name,
            'display_name' => $action_data->display_name,
            'description' => $action_data->description
        ]);
        return new CommonActionResult($permission->id);
    }

    /**
     * @param int $id
     * @return VoidActionResult
     */
    public function delete(int $id){
        Permission::query()->findOrFail($id)->delete();
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return PermissionDataObject
     */
    public function show(int $id){
        return new PermissionDataObject(Permission::query()->findOrFail($id)->toArray());
    }

    /**
     * @param int $id
     * @return PermissionDataObject
     */
    public function get(int $id){
        $item = Permission::query()->findOrFail($id);
        $result = new PermissionDataObject($item->toArray());
        $result->display_name = json_decode($item->getRawOriginal('display_name'));
        $result->description = json_decode($item->getRawOriginal('description'));
        return $result;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginate(int $page = 1, int $limit = 25, ?iterable $filters = null){
        $permissions = Permission::query()->latest()->paginate($limit);
        $items = $permissions->getCollection()->transform(function ($item){
            return new PermissionDataObject($item->toArray());
        });
        return new DataObjectPagination($items, $permissions->total(), $limit, $page);
    }
}
