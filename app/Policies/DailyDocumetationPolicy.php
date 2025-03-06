<?php

namespace App\Policies;

use App\Models\DailyDocumetation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyDocumetationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyDocumetation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dailydocumetations');
    }

    /**
     * Determine whether the dailyDocumetation can view the model.
     */
    public function view(User $user, DailyDocumetation $model): bool
    {
        return $user->hasPermissionTo('view dailydocumetations');
    }

    /**
     * Determine whether the dailyDocumetation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dailydocumetations');
    }

    /**
     * Determine whether the dailyDocumetation can update the model.
     */
    public function update(User $user, DailyDocumetation $model): bool
    {
        return $user->hasPermissionTo('update dailydocumetations');
    }

    /**
     * Determine whether the dailyDocumetation can delete the model.
     */
    public function delete(User $user, DailyDocumetation $model): bool
    {
        return $user->hasPermissionTo('delete dailydocumetations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dailydocumetations');
    }

    /**
     * Determine whether the dailyDocumetation can restore the model.
     */
    public function restore(User $user, DailyDocumetation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dailyDocumetation can permanently delete the model.
     */
    public function forceDelete(User $user, DailyDocumetation $model): bool
    {
        return false;
    }
}
