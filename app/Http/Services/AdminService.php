<?php

namespace App\Http\Services;

use App\Enums\Roles;
use App\Http\Requests\Post\AdminRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Throwable;

class AdminService
{
    /**
     * @throws Throwable
     */
    public function store(AdminRequest $request): User
    {
        $password = Str::password();
        $user = new User($request->validated());

        $user->setPassword($password);
        $user->saveOrFail();

        $user->assign(Roles::ADMIN->name);

        return $user;
    }

    /**
     * @throws Throwable
     */
    public function update(AdminRequest $request, User $user): User
    {
        $user->fill($request->validated())->saveOrFail();

        return $user;
    }

    /**
     * @throws Throwable
     */
    public function destroy(User $user): void
    {
        $user->deleteOrFail();
    }
}
