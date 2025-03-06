<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Weather;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeatherPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the weather can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list weathers');
    }

    /**
     * Determine whether the weather can view the model.
     */
    public function view(User $user, Weather $model): bool
    {
        return $user->hasPermissionTo('view weathers');
    }

    /**
     * Determine whether the weather can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create weathers');
    }

    /**
     * Determine whether the weather can update the model.
     */
    public function update(User $user, Weather $model): bool
    {
        return $user->hasPermissionTo('update weathers');
    }

    /**
     * Determine whether the weather can delete the model.
     */
    public function delete(User $user, Weather $model): bool
    {
        return $user->hasPermissionTo('delete weathers');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete weathers');
    }

    /**
     * Determine whether the weather can restore the model.
     */
    public function restore(User $user, Weather $model): bool
    {
        return false;
    }

    /**
     * Determine whether the weather can permanently delete the model.
     */
    public function forceDelete(User $user, Weather $model): bool
    {
        return false;
    }
}
