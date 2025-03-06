<?php

namespace App\Policies;

use App\Models\Humidity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HumidityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the humidity can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list humidities');
    }

    /**
     * Determine whether the humidity can view the model.
     */
    public function view(User $user, Humidity $model): bool
    {
        return $user->hasPermissionTo('view humidities');
    }

    /**
     * Determine whether the humidity can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create humidities');
    }

    /**
     * Determine whether the humidity can update the model.
     */
    public function update(User $user, Humidity $model): bool
    {
        return $user->hasPermissionTo('update humidities');
    }

    /**
     * Determine whether the humidity can delete the model.
     */
    public function delete(User $user, Humidity $model): bool
    {
        return $user->hasPermissionTo('delete humidities');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete humidities');
    }

    /**
     * Determine whether the humidity can restore the model.
     */
    public function restore(User $user, Humidity $model): bool
    {
        return false;
    }

    /**
     * Determine whether the humidity can permanently delete the model.
     */
    public function forceDelete(User $user, Humidity $model): bool
    {
        return false;
    }
}
