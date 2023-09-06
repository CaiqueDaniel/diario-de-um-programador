<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\Bouncer;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bouncer = Bouncer::create();
        $user = new User([
            'name' => 'Teste',
            'email' => 'teste@gmail.com',
        ]);

        $user->setPassword('123456');
        $user->saveOrFail();

        $bouncer->assign(Roles::SUPER_ADMIN->name)->to($user);
    }
}
