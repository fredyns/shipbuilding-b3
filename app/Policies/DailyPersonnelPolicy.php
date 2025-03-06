<?php

namespace App\Policies;

use App\Models\DailyPersonnel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyPersonnelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyPersonnel can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dailypersonnels');
    }

    /**
     * Determine whether the dailyPersonnel can view the model.
     */
    public function view(User $user, DailyPersonnel $model): bool
    {
        return $user->hasPermissionTo('view dailypersonnels');
    }

    /**
     * Determine whether the dailyPersonnel can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dailypersonnels');
    }

    /**
     * Determine whether the dailyPersonnel can update the model.
     */
    public function update(User $user, DailyPersonnel $model): bool
    {
        return $user->hasPermissionTo('update dailypersonnels');
    }

    /**
     * Determine whether the dailyPersonnel can delete the model.
     */
    public function delete(User $user, DailyPersonnel $model): bool
    {
        return $user->hasPermissionTo('delete dailypersonnels');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dailypersonnels');
    }

    /**
     * Determine whether the dailyPersonnel can restore the model.
     */
    public function restore(User $user, DailyPersonnel $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dailyPersonnel can permanently delete the model.
     */
    public function forceDelete(User $user, DailyPersonnel $model): bool
    {
        return false;
    }
}
