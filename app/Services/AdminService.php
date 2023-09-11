<?php

namespace App\Services;

use App\Enums\Roles;
use App\Http\Requests\Post\AdminRequest;
use App\Models\User;
use App\Notifications\{AccountDeletedNotification, AccountUpdatedNotification, AdminAccountCreatedNotification};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class AdminService
{
    public function store(AdminRequest $request): User
    {
        $user = new User($request->validated());

        DB::transaction(function () use ($user) {
            $password = Str::random();

            $user->setPassword($password);
            $user->saveOrFail();

            $user->assign(Roles::ADMIN->name);
            $user->notify(new AdminAccountCreatedNotification($user, $password));
        });

        return $user;
    }

    public function update(AdminRequest $request, User $user): User
    {
        DB::transaction(function () use ($user, $request) {
            $user->fill($request->validated())->saveOrFail();
            $user->notify(new AccountUpdatedNotification($user));
        });

        return $user;
    }

    /**
     * @throws Throwable
     */
    public function destroy(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->deleteOrFail();
            $user->notify(new AccountDeletedNotification($user));
        });
    }
}
