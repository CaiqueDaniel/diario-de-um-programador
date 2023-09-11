<?php

namespace App\Services;

use App\Http\Requests\Post\UserRequest;
use App\Models\User;
use App\Notifications\AccountUpdatedNotification;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function update(UserRequest $request, User $user): User
    {
        DB::transaction(function () use ($user, $request) {
            if (!empty($request->get('password')))
                $user->setPassword($request->get('password'));

            $user->fill($request->validated())->saveOrFail();
            $user->notify(new AccountUpdatedNotification($user));
        });

        return $user;
    }
}
