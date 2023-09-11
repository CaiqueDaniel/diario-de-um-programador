<?php

namespace App\Actions\Users;

use App\Models\User;
use App\Notifications\AccountDeletedNotification;
use Illuminate\Support\Facades\DB;

class DeleteUserAction
{
    public function execute(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->deleteOrFail();
            $user->notify(new AccountDeletedNotification($user));
        });
    }
}
