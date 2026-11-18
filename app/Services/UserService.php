<?php

namespace App\Services;

use App\Actions\Users\UpdateEmailAction;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserService
{

    public function update(
        UpdateUserRequest $updateUserRequest,
        User $user
    ): User {

        //$email = $updateUserRequest->email;
        //$email_verified_at = date($user->email_verified_at);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        /*$user->update([
            'name' => $updateUserRequest->name,
            'email' => $email,
            'email_verified_at' => $email_verified_at,
            'role_id' => $updateUserRequest->role_id,
        ]);*/
        $user->save();


        return $user;
    }
}
