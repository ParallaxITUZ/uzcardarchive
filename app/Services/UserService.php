<?php

namespace App\Services;

use App\ActionData\User\UserActionData;
use App\ActionData\User\UserResetPasswordActionData;
use App\ActionData\User\UserUpdateActionData;
use App\ActionResults\CommonActionResult;
use App\ActionResults\VoidActionResult;
use App\Contracts\PaginatorInterface;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\User\UserDataObject;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Services\Concerns\Paginator;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService implements PaginatorInterface
{
    use Paginator;

    /**
     * @param \App\ActionData\User\UserActionData $action_data
     * @return \App\ActionResults\CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function create(UserActionData $action_data): CommonActionResult {
        try {
            DB::beginTransaction();
            $action_data->validate();
            $user = User::query()->create([
                'login' => $action_data->login,
                'password' => Hash::make($action_data->password)
            ]);
            $user->attachRoles($action_data->role);
            Profile::query()->create([
                'name' => $action_data->name,
                'region_id' => $action_data->region_id,
                'address' => $action_data->address,
                'pinfl' => $action_data->pinfl,
                'phone' => $action_data->phone,
                'user_id' => $user->id,
                'organization_id' => $action_data->organization_id,
                'position_id' => $action_data->position_id,
            ]);
            DB::commit();
            return new CommonActionResult($user->id);
        } catch (Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param \App\ActionData\User\UserUpdateActionData $action_data
     * @return \App\ActionResults\CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function update(UserUpdateActionData $action_data): CommonActionResult {
        try {
            DB::beginTransaction();
            $action_data->validate();
            $user = User::query()->findOrFail($action_data->id);
            $user->detachRoles(Role::all());
            $user->attachRoles($action_data->role);
            $profile = $user->profile;
            $profile->update([
                'name' => $action_data->name,
                'region_id' => $action_data->region_id,
                'address' => $action_data->address,
                'pinfl' => $action_data->pinfl,
                'phone' => $action_data->phone,
                'position_id' => $action_data->position_id,
            ]);
            DB::commit();
            return new CommonActionResult($user->id);
        } catch (Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param UserResetPasswordActionData $user_action_data
     * @param int $id
     * @return CommonActionResult
     * @throws ValidationException
     */
    public function resetPassword(UserResetPasswordActionData $user_action_data, int $id): CommonActionResult
    {
        $user_action_data->validate();

        $user = User::query()->find($id);
        $user->update([
            'password' => Hash::make($user_action_data->password)
        ]);
        return new CommonActionResult($user->id);
    }

    /**
     * @param int $id
     * @return VoidActionResult
     * @throws \Throwable
     */
    public function activate(int $id){
        $user = User::query()->findOrFail($id);
        $user->detachRoles(Role::all());
        $user->updateOrFail([
            'status' => 10,
        ]);
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return VoidActionResult
     * @throws \Throwable
     */
    public function deactivate(int $id){
        $user = User::query()->findOrFail($id);
        $user->detachRoles(Role::all());
        $user->updateOrFail([
            'status' => 9,
        ]);
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return VoidActionResult
     * @throws \Throwable
     */
    public function delete(int $id){
        $user = User::query()->findOrFail($id);
        $user->detachRoles(Role::all());
        $user->updateOrFail([
            'status' => 0,
            'is_deleted' => true,
        ]);
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return UserDataObject
     */
    public function get(int $id){
        $user = User::query()->findOrFail($id);
        $result = new UserDataObject($user->toArray());
        $result->name = $user->profile->name;
        $result->region = $user->profile->region;
        $result->region_id = $user->profile->region_id;
        $result->organization = $user->profile->organization;
        $result->organization_id = $user->profile->organization_id;
        $result->position = $user->profile->position;
        $result->position_id = $user->profile->position_id;
        $result->phone = $user->profile->phone;
        $result->address = $user->profile->address;
        $result->pinfl = $user->profile->pinfl;
        $result->roles = $user->roles;
        return $result;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginate(
        int $page = 1,
        int $limit = 25,
        ?iterable $filters = null
    ): DataObjectPagination
    {
        $closure = function ($item) {
            $result = new UserDataObject($item->toArray());
            $result->name = $item->profile->name;
            $result->region = $item->profile->region;
            $result->organization = $item->profile->organization;
            $result->position = $item->profile->position;
            $result->phone = $item->profile->phone;
            $result->address = $item->profile->address;
            $result->pinfl = $item->profile->pinfl;
            $result->roles = $item->getRoles();
            return $result;
        };

        return $this->filterAndPaginate(
            User::query()
                ->where('id', '!=', Auth::user()->id)
                ->where('status', '<>', 0)
                ->where('is_deleted', '=', false),
            $page,
            $limit,
            $closure
        );
    }
}
