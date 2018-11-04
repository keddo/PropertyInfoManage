<?php

namespace App\Providers;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isSuperAdmin', function($user){
            return $user->type == 'Super Admin';
        });

        Gate::define('isTeacher', function($user){
            return $user->type == 'Teacher';
        });

        Gate::define('isHead', function($user){
            return $user->type == 'Head';
        });
        Passport::routes();
        
    }
}
