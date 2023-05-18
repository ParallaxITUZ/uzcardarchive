<?php

namespace App\Services;

use App\ActionData\ActionDataBase;
use App\ActionResults\Auth\AuthActionResult;
use App\Exceptions\JsonRpcException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService {
    /**
     * @param \App\ActionData\ActionDataBase $action_data
     * @return \App\ActionResults\Auth\AuthActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(ActionDataBase $action_data): AuthActionResult {
        $action_data->validate();

        // Check login
        $user = User::query()->where('login', $action_data->login)->firstOrFail();
        if (!$user->hasRole('superadmin')){
            return (new AuthActionResult([]))->setError('Bad Credentials', JsonRpcException::INVALID_PARAMS);
        }

        // Check password
        if(!$user || !Hash::check($action_data->password, $user->password)) {
            return (new AuthActionResult([]))->setError('Bad Credentials', JsonRpcException::INVALID_PARAMS);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return new AuthActionResult(['token' => $token, 'user' => $user]);
    }

    /**
     * @param \App\ActionData\ActionDataBase $action_data
     * @return \App\ActionResults\Auth\AuthActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginWorker(ActionDataBase $action_data): AuthActionResult {
        $action_data->validate();

        // Check login
        $user = User::query()->where('login', $action_data->login)->firstOrFail();
        if ($user->hasRole('superadmin')){
            return (new AuthActionResult([]))->setError('Bad Credentials', JsonRpcException::INVALID_PARAMS);
        }

        // Check password
        if(!$user || !Hash::check($action_data->password, $user->password)) {
            return (new AuthActionResult([]))->setError('Bad Credentials', JsonRpcException::INVALID_PARAMS);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return new AuthActionResult(['token' => $token, 'user' => $user]);
    }

    public function refreshToken(){
        return true;
    }

    public function authUser(){
        if ($user = Auth::user()){
            $organization_type = $user->profile->organization->organizationType;
            $permissions = $user->allPermissions();
            $roles = $user->getRoles();
            return new AuthActionResult([
                'user' => $user,
                'role' => $roles,
                'permissions' => $permissions,
                'organization_type' => $organization_type
            ]);
        }
        return (new AuthActionResult())->setError('Unauthorized', JsonRpcException::UNAUTHENTICATED);
    }

    public function logout(){
        return true;
    }
}
