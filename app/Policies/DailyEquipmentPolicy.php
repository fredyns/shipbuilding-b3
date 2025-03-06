<?php

namespace App\Policies;

use App\Models\DailyEquipment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyEquipmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyEquipment can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dailyequipments');
    }

    /**
     * Determine whether the dailyEquipment can view the model.
     */
    public function view(User $user, DailyEquipment $model): bool
    {
        return $user->hasPermissionTo('view dailyequipments');
    }

    /**
     * Determine whether the dailyEquipment can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dailyequipments');
    }

    /**
     * Determine whether the dailyEquipment can update the model.
     */
    public function update(User $user, DailyEquipment $model): bool
    {
        return $user->hasPermissionTo('update dailyequipments');
    }

    /**
     * Determine whether the dailyEquipment can delete the model.
     */
    public function delete(User $user, DailyEquipment $model): bool
    {
        return $user->hasPermissionTo('delete dailyequipments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dailyequipments');
    }

    /**
     * Determine whether the dailyEquipment can restore the model.
     */
    public function restore(User $user, DailyEquipment $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dailyEquipment can permanently delete the model.
     */
    public function forceDelete(User $user, DailyEquipment $model): bool
    {
        return false;
    }
}
