<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Hostel;

use App\Policies\HostelPolicy;
use App\Policies\RoomPolicy;
use App\Policies\AllotmentPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        // Gate::define('update-hostel', function (User $user, Hostel $hostel) {
        //     return $user->isWarden($hostel->id);
        // });
        Gate::policy(Hostel::class, HostelPolicy::class);
        Gate::policy(Allotment::class, AllotmentPolicy::class);
        // Gate::define('view-allotment', [AllotmentPolicy::class,'view']);


        Gate::define('admin-access', function (User $user) {
            return $user->isAdmin(); // Assuming you have an 'is_admin' column in your users table
        });
    }
}
