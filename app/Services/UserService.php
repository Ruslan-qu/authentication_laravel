<?php

namespace App\Services;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserService
{

    public function update(
        UpdateUserRequest $updateUserRequest,
        User $user
    ): User {
        dd($updateUserRequest->name);
        $user->update([
            'name' => $updateUserRequest->name,
            'email' => $updateUserRequest->input('email'),
        ]);

        return $user;
    }
}
