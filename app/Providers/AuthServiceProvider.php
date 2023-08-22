<?php

namespace App\Providers;

use App\Enums\Abilities;
use App\Enums\Roles;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Silber\Bouncer\Bouncer;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerRolesAndAbilities();
    }

    public function registerRolesAndAbilities()
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
