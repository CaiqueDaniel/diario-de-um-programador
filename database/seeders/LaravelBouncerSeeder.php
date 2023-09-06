<?php

namespace Database\Seeders;

use App\Enums\{Abilities, Roles};
use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

class LaravelBouncerSeeder extends Seeder
{
    public function run(): void
    {
        $abilities = array_map(fn(Abilities $ability) => $ability->name, Abilities::cases());

        $bouncer = Bouncer::create();

        $bouncer->allow(Roles::SUPER_ADMIN->name)->everything();
        $bouncer->allow(Roles::ADMIN->name)->to($abilities);

        /*$bouncer->allow(Roles::VIEWER->name)->to([

        ]);*/
    }
}
