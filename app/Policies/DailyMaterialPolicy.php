<?php

namespace App\Policies;

use App\Models\DailyMaterial;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyMaterialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyMaterial can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dailymaterials');
    }

    /**
     * Determine whether the dailyMaterial can view the model.
     */
    public function view(User $user, DailyMaterial $model): bool
    {
        return $user->hasPermissionTo('view dailymaterials');
    }

    /**
     * Determine whether the dailyMaterial can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dailymaterials');
    }

    /**
     * Determine whether the dailyMaterial can update the model.
     */
    public function update(User $user, DailyMaterial $model): bool
    {
        return $user->hasPermissionTo('update dailymaterials');
    }

    /**
     * Determine whether the dailyMaterial can delete the model.
     */
    public function delete(User $user, DailyMaterial $model): bool
    {
        return $user->hasPermissionTo('delete dailymaterials');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dailymaterials');
    }

    /**
     * Determine whether the dailyMaterial can restore the model.
     */
    public function restore(User $user, DailyMaterial $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dailyMaterial can permanently delete the model.
     */
    public function forceDelete(User $user, DailyMaterial $model): bool
    {
        return false;
    }
}
