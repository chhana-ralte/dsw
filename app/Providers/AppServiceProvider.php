<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Hostel;
use App\Models\Allotment;

use App\Policies\HostelPolicy;
use App\Policies\RoomPolicy;
use App\Policies\AllotmentPolicy;
use App\Policies\AdmissionPolicy;
use App\Policies\SearchPolicy;

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
        // Gate::policy(Hostel::class, HostelPolicy::class);
        // Gate::policy(Allotment::class, AllotmentPolicy::class);
        // Gate::define('view-allotment', [AllotmentPolicy::class,'view']);

        // Gate::policy(SearchPolicy::class);
        Gate::define('search', [SearchPolicy::class, 'search']);

        Gate::define('admin-access', function (User $user) {
            return $user->isAdmin(); // Assuming you have an 'is_admin' column in your users table
        });

        Gate::define('verify-admission', function (User $user, Hostel $hostel) {
            return $user->isWardenOf($hostel->id) || $user->isDsw() || $user->isFinance();
        });

        Gate::define('update-admission', [AdmissionPolicy::class, 'update_admission']);

        Gate::define('create-admission', function (User $user, Allotment $allotment) {
            if ($user->isDsw() || ($user->allotment() && $user->allotment()->id == $allotment->id)) {
                return true;
            } else {
                if ($allotment->valid_allot_hostel()) {
                    return $user->isWardenOf($allotment->valid_allot_hostel()->hostel_id);
                } else {
                    return false;
                }
            }
        });
    }
}
