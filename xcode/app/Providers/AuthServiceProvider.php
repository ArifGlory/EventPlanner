<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
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
        Gate::before(function ($user, $ability) {
            return $user->access == 'admin' ? true : null;
        });
        Gate::define('layanan', function (User $user, ...$roles) {
            return $user->layanan->pluck('nama_layanan')->contains(function ($item, $key) use ($roles) {
                if (in_array($item, $roles)) {
                    return true;
                } else {
                    return false;
                }
            });

        });
        Gate::define('fitur', function (User $user, ...$fitur) {
            return $user->fitur->pluck('nama_fitur')->contains(function ($item, $key) use ($fitur) {
                if (in_array($item, $fitur)) {
                    return true;
                } else {
                    return false;
                }
            });

        });
    }
}
