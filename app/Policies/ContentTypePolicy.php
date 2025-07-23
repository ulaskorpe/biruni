<?php

namespace App\Policies;

use App\Models\ContentType;
use App\Models\User;

class ContentTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view-ContentType');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentType $contentType): bool
    {
        return $user->hasPermissionTo('view-ContentType');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-ContentType');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentType $contentType): bool
    {
        return $user->hasPermissionTo('edit-ContentType');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentType $contentType): bool
    {
        return $user->hasPermissionTo('delete-ContentType');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentType $contentType): bool
    {
        return $user->hasPermissionTo('delete-ContentType');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentType $contentType): bool
    {
        return $user->hasPermissionTo('delete-ContentType');
    }
}
