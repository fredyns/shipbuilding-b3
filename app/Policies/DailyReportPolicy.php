<?php

namespace App\Policies;

use App\Models\DailyReport;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyReport can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dailyreports');
    }

    /**
     * Determine whether the dailyReport can view the model.
     */
    public function view(User $user, DailyReport $model): bool
    {
        return $user->hasPermissionTo('view dailyreports');
    }

    /**
     * Determine whether the dailyReport can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dailyreports');
    }

    /**
     * Determine whether the dailyReport can update the model.
     */
    public function update(User $user, DailyReport $model): bool
    {
        return $user->hasPermissionTo('update dailyreports');
    }

    /**
     * Determine whether the dailyReport can delete the model.
     */
    public function delete(User $user, DailyReport $model): bool
    {
        return $user->hasPermissionTo('delete dailyreports');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dailyreports');
    }

    /**
     * Determine whether the dailyReport can restore the model.
     */
    public function restore(User $user, DailyReport $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dailyReport can permanently delete the model.
     */
    public function forceDelete(User $user, DailyReport $model): bool
    {
        return false;
    }
}
