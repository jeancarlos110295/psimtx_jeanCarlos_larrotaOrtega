<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Passport\Passport;
use App\Policies\PolicyContactos;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(1));

        Gate::define('permiso-admin', function(User $user){
            return $user->rol === User::ROL_ADMIN;
        });
    }
}
