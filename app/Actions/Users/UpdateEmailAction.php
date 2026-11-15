<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;


final readonly class UpdateEmailAction
{

    public function handle(string $email, User $user): string
    {

        return $email;
    }
}
