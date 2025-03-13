<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MonthlyReport;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonthlyReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the monthlyReport can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list monthlyreports');
    }

    /**
     * Determine whether the monthlyReport can view the model.
     */
    public function view(User $user, MonthlyReport $model): bool
    {
        return $user->hasPermissionTo('view monthlyreports');
    }

    /**
     * Determine whether the monthlyReport can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create monthlyreports');
    }

    /**
     * Determine whether the monthlyReport can update the model.
     */
    public function update(User $user, MonthlyReport $model): bool
    {
        return $user->hasPermissionTo('update monthlyreports');
    }

    /**
     * Determine whether the monthlyReport can delete the model.
     */
    public function delete(User $user, MonthlyReport $model): bool
    {
        return $user->hasPermissionTo('delete monthlyreports');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete monthlyreports');
    }

    /**
     * Determine whether the monthlyReport can restore the model.
     */
    public function restore(User $user, MonthlyReport $model): bool
    {
        return false;
    }

    /**
     * Determine whether the monthlyReport can permanently delete the model.
     */
    public function forceDelete(User $user, MonthlyReport $model): bool
    {
        return false;
    }
}
