<?php

namespace App\Policies;

use App\Models\DailyActivity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyActivityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyActivity can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dailyactivities');
    }

    /**
     * Determine whether the dailyActivity can view the model.
     */
    public function view(User $user, DailyActivity $model): bool
    {
        return $user->hasPermissionTo('view dailyactivities');
    }

    /**
     * Determine whether the dailyActivity can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dailyactivities');
    }

    /**
     * Determine whether the dailyActivity can update the model.
     */
    public function update(User $user, DailyActivity $model): bool
    {
        return $user->hasPermissionTo('update dailyactivities');
    }

    /**
     * Determine whether the dailyActivity can delete the model.
     */
    public function delete(User $user, DailyActivity $model): bool
    {
        return $user->hasPermissionTo('delete dailyactivities');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dailyactivities');
    }

    /**
     * Determine whether the dailyActivity can restore the model.
     */
    public function restore(User $user, DailyActivity $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dailyActivity can permanently delete the model.
     */
    public function forceDelete(User $user, DailyActivity $model): bool
    {
        return false;
    }
}
