<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('view-User');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('view-User');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('create-User');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('edit-User');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('delete-User');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('delete-User');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('delete-User');
    }


    ////CUSTOMERS
    /**
     * Determine whether the user can view any models.
     */
    public function viewAnyCustomer(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('view-customer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewCustomer(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('view-customer');
    }

    /**
     * Determine whether the user can create models.
     */
    public function createCustomer(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('create-customer');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateCustomer(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('edit-customer');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteCustomer(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('delete-customer');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restoreCustomer(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('delete-customer');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteCustomer(User $currentUser): bool
    {
        return $currentUser->hasPermissionTo('delete-customer');
    }



}
