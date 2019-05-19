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
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies()
    {
        return $this->policies;
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPassport();
        //
    }

    /**
     * Register passport
     * @return void
     */
    private function registerPassport()
    {
        Passport::routes();
        Passport::tokensExpireIn(\Carbon\Carbon::now()->addYears(1));
        //Passport::allowMultipleTokens();
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register gates
     * @return void
     */
    private function registerGates()
    {
        // user
//        Gate::define('user.view', 'App\Policies\UserPolicy@view');
//        Gate::define('user.create', 'App\Policies\UserPolicy@create');
//        Gate::define('user.update', 'App\Policies\UserPolicy@update');
//        Gate::define('user.delete', 'App\Policies\UserPolicy@delete');
        $permissions = config('permissions');
        foreach ($permissions as $key => $role) {
            if ($key !== 'admin') {
                foreach ($role['list'] as $key_role => $per) {
                    Gate::define("{$key}.{$key_role}", 'App\Policies\\' . ucfirst($key) . 'Policy@' . $key_role);
                }
            }
        }
    }
}
