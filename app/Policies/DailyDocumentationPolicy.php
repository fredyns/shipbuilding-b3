<?php

namespace App\Policies;

use App\Models\DailyDocumentation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DailyDocumentationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the dailyDocumentation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list dailydocumentations');
    }

    /**
     * Determine whether the dailyDocumentation can view the model.
     */
    public function view(User $user, DailyDocumentation $model): bool
    {
        return $user->hasPermissionTo('view dailydocumentations');
    }

    /**
     * Determine whether the dailyDocumentation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create dailydocumentations');
    }

    /**
     * Determine whether the dailyDocumentation can update the model.
     */
    public function update(User $user, DailyDocumentation $model): bool
    {
        return $user->hasPermissionTo('update dailydocumentations');
    }

    /**
     * Determine whether the dailyDocumentation can delete the model.
     */
    public function delete(User $user, DailyDocumentation $model): bool
    {
        return $user->hasPermissionTo('delete dailydocumentations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete dailydocumentations');
    }

    /**
     * Determine whether the dailyDocumentation can restore the model.
     */
    public function restore(User $user, DailyDocumentation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the dailyDocumentation can permanently delete the model.
     */
    public function forceDelete(User $user, DailyDocumentation $model): bool
    {
        return false;
    }
}
