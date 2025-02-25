<?php

namespace App\Policies;

use App\Models\Shipyard;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipyardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shipyard can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list shipyards');
    }

    /**
     * Determine whether the shipyard can view the model.
     */
    public function view(User $user, Shipyard $model): bool
    {
        return $user->hasPermissionTo('view shipyards');
    }

    /**
     * Determine whether the shipyard can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create shipyards');
    }

    /**
     * Determine whether the shipyard can update the model.
     */
    public function update(User $user, Shipyard $model): bool
    {
        return $user->hasPermissionTo('update shipyards');
    }

    /**
     * Determine whether the shipyard can delete the model.
     */
    public function delete(User $user, Shipyard $model): bool
    {
        return $user->hasPermissionTo('delete shipyards');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete shipyards');
    }

    /**
     * Determine whether the shipyard can restore the model.
     */
    public function restore(User $user, Shipyard $model): bool
    {
        return false;
    }

    /**
     * Determine whether the shipyard can permanently delete the model.
     */
    public function forceDelete(User $user, Shipyard $model): bool
    {
        return false;
    }
}
