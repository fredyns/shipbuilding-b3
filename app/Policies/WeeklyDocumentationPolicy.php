<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyDocumentation;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeeklyDocumentationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the weeklyDocumentation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list weeklydocumentations');
    }

    /**
     * Determine whether the weeklyDocumentation can view the model.
     */
    public function view(User $user, WeeklyDocumentation $model): bool
    {
        return $user->hasPermissionTo('view weeklydocumentations');
    }

    /**
     * Determine whether the weeklyDocumentation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create weeklydocumentations');
    }

    /**
     * Determine whether the weeklyDocumentation can update the model.
     */
    public function update(User $user, WeeklyDocumentation $model): bool
    {
        return $user->hasPermissionTo('update weeklydocumentations');
    }

    /**
     * Determine whether the weeklyDocumentation can delete the model.
     */
    public function delete(User $user, WeeklyDocumentation $model): bool
    {
        return $user->hasPermissionTo('delete weeklydocumentations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete weeklydocumentations');
    }

    /**
     * Determine whether the weeklyDocumentation can restore the model.
     */
    public function restore(User $user, WeeklyDocumentation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the weeklyDocumentation can permanently delete the model.
     */
    public function forceDelete(User $user, WeeklyDocumentation $model): bool
    {
        return false;
    }
}
