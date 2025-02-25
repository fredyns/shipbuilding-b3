<?php

namespace App\Policies;

use App\Models\ShipbuildingTask;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipbuildingTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shipbuildingTask can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list shipbuildingtasks');
    }

    /**
     * Determine whether the shipbuildingTask can view the model.
     */
    public function view(User $user, ShipbuildingTask $model): bool
    {
        return $user->hasPermissionTo('view shipbuildingtasks');
    }

    /**
     * Determine whether the shipbuildingTask can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create shipbuildingtasks');
    }

    /**
     * Determine whether the shipbuildingTask can update the model.
     */
    public function update(User $user, ShipbuildingTask $model): bool
    {
        return $user->hasPermissionTo('update shipbuildingtasks');
    }

    /**
     * Determine whether the shipbuildingTask can delete the model.
     */
    public function delete(User $user, ShipbuildingTask $model): bool
    {
        return $user->hasPermissionTo('delete shipbuildingtasks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete shipbuildingtasks');
    }

    /**
     * Determine whether the shipbuildingTask can restore the model.
     */
    public function restore(User $user, ShipbuildingTask $model): bool
    {
        return false;
    }

    /**
     * Determine whether the shipbuildingTask can permanently delete the model.
     */
    public function forceDelete(User $user, ShipbuildingTask $model): bool
    {
        return false;
    }
}
