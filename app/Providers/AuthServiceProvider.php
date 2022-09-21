<?php

namespace App\Providers;

use App\Models\Todo;
use App\Models\User;
use App\Policies\TodoPolicy;
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
        Todo::class => TodoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-todo', function (User $user, Todo $todo) {
            return $user->id === $todo->user_id;
        });
        Gate::define('delete-todo', function (User $user, Todo $todo) {
            return $user->id === $todo->user_id;
        });
    }
}
