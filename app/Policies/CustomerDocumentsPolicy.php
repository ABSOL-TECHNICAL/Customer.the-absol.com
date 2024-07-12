<?php

namespace App\Policies;

use App\Models\CustomerDocuments;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomerDocumentspolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        // if($user->hasRole(['Admin']) ){
        //     return true;
        // }
        // return false;
        if($user->hasPermissionTo('View CustomerDocuments')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustomerDocuments $customerDocuments)
    {
        //
        if($user->hasPermissionTo('View CustomerDocuments')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
        if($user->hasPermissionTo('Create CustomerDocuments')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomerDocuments $customerDocuments)
    {
        //
        if($user->hasPermissionTo('Update CustomerDocuments')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomerDocuments $customerDocuments)
    {
        //
        if($user->hasPermissionTo('Delete CustomerDocuments')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomerDocuments $customerDocuments)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomerDocuments $customerDocuments)
    {
        //
    }
}
