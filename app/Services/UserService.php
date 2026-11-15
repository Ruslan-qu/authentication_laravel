<?php

namespace App\Services;

use App\Actions\Users\UpdateEmailAction;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserService
{

    public function update(
        UpdateUserRequest $updateUserRequest,
        User $user,
        UpdateEmailAction $updateEmailAction
    ): User {
        dd($updateUserRequest->name);
        $user->update([
            'name' => $updateUserRequest->name,
            'email' => $updateEmailAction->handle($updateUserRequest->email, $user),
            'role_id' => $updateUserRequest->role_id,
        ]);

        return $user;
    }
}
