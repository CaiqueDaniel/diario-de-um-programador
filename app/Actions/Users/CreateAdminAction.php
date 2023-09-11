<?php

namespace App\Actions\Users;

use App\Dtos\Users\UserDto;
use App\Enums\Roles;
use App\Models\User;
use App\Notifications\AdminAccountCreatedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateAdminAction
{
    public function execute(UserDto $userDto): User
    {
        $user = new User($userDto->toArray());

        DB::transaction(function () use ($user) {
            $password = Str::random();

            $user->setPassword($password);
            $user->saveOrFail();

            $user->assign(Roles::ADMIN->name);
            $user->notify(new AdminAccountCreatedNotification($user, $password));
        });

        return $user;
    }
}
