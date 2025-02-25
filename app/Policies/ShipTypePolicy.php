<?php

namespace App\Policies;

use App\Models\ShipType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the shipType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list shiptypes');
    }

    /**
     * Determine whether the shipType can view the model.
     */
    public function view(User $user, ShipType $model): bool
    {
        return $user->hasPermissionTo('view shiptypes');
    }

    /**
     * Determine whether the shipType can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create shiptypes');
    }

    /**
     * Determine whether the shipType can update the model.
     */
    public function update(User $user, ShipType $model): bool
    {
        return $user->hasPermissionTo('update shiptypes');
    }

    /**
     * Determine whether the shipType can delete the model.
     */
    public function delete(User $user, ShipType $model): bool
    {
        return $user->hasPermissionTo('delete shiptypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete shiptypes');
    }

    /**
     * Determine whether the shipType can restore the model.
     */
    public function restore(User $user, ShipType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the shipType can permanently delete the model.
     */
    public function forceDelete(User $user, ShipType $model): bool
    {
        return false;
    }
}
