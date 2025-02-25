<?php

namespace App\Policies;

use App\Models\Shipbuilding;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipbuildingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shipbuilding can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list shipbuildings');
    }

    /**
     * Determine whether the shipbuilding can view the model.
     */
    public function view(User $user, Shipbuilding $model): bool
    {
        return $user->hasPermissionTo('view shipbuildings');
    }

    /**
     * Determine whether the shipbuilding can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create shipbuildings');
    }

    /**
     * Determine whether the shipbuilding can update the model.
     */
    public function update(User $user, Shipbuilding $model): bool
    {
        return $user->hasPermissionTo('update shipbuildings');
    }

    /**
     * Determine whether the shipbuilding can delete the model.
     */
    public function delete(User $user, Shipbuilding $model): bool
    {
        return $user->hasPermissionTo('delete shipbuildings');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete shipbuildings');
    }

    /**
     * Determine whether the shipbuilding can restore the model.
     */
    public function restore(User $user, Shipbuilding $model): bool
    {
        return false;
    }

    /**
     * Determine whether the shipbuilding can permanently delete the model.
     */
    public function forceDelete(User $user, Shipbuilding $model): bool
    {
        return false;
    }
}
