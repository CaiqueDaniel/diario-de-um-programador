<?php

namespace Database\Seeders;

use App\Enums\{Abilities, Roles};
use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

class LaravelBouncerSeeder extends Seeder
{
    public function run(): void
    {
        $bouncer = Bouncer::create();
        $bouncer->allow(Roles::SUPER_ADMIN->name)->everything();

        $bouncer->allow(Roles::ADMIN->name)->to([
            Abilities::CREATE_POSTS->name,
            Abilities::EDIT_POSTS->name,
            Abilities::DELETE_POSTS->name,
            Abilities::CREATE_CATEGORIES->name,
            Abilities::EDIT_CATEGORIES->name,
            Abilities::DELETE_CATEGORIES->name,
            Abilities::CREATE_BANNERS->name,
            Abilities::EDIT_BANNERS->name,
            Abilities::DELETE_BANNERS->name,
        ]);

        /*$bouncer->allow(Roles::VIEWER->name)->to([

        ]);*/
    }
}
