<?php 
namespace App\Providers;

use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('assign-task', function ($user) {
            return $user->role === 'admin'; // Only admins can assign tasks
        });

        Gate::define('update-task', function ($user, Task $task) {
            return $user->id === $task->assigned_user || $user->role === 'admin'; // Users can only update their own tasks
        });

        Gate::define('delete-task', function ($user) {
            return $user->role === 'admin'; // Only admins can delete tasks
        });
    }
}
