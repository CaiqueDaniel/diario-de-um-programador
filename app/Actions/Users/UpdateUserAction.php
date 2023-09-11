<?php

namespace App\Actions\Users;

use App\Dtos\Users\UserDto;
use App\Models\User;
use App\Notifications\AccountUpdatedNotification;
use Illuminate\Support\Facades\DB;

class UpdateUserAction
{
    public function execute(UserDto $dto, User $user): User
    {
        DB::transaction(function () use ($dto, $user) {
            $user->fill($dto->toArray());

            if (!empty($dto->getPassword()))
                $user->setPassword($dto->getPassword());

            $user->saveOrFail();
            $user->notify(new AccountUpdatedNotification($user));
        });

        return $user;
    }
}
