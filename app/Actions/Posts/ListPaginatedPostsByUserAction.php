<?php

namespace App\Actions\Posts;

use App\Enums\Roles;
use App\Models\{Post, User};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListPaginatedPostsByUserAction
{
    public function execute(User $user, ?string $search): LengthAwarePaginator
    {
        if ($this->isUserSuperAdmin($user)) {
            return Post::findAll($search);
        }

        return Post::findAllByAuthor($user, $search);
    }

    private function isUserSuperAdmin(User $user): bool
    {
        return in_array(Roles::SUPER_ADMIN->name, $user->getRoles()->toArray());
    }
}
