<?php

namespace App\Policies;

use App\Models\Documents;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Documentspolicy
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
        if($user->hasPermissionTo('View Documents') || $user->hasRole(['Document Viewer'])) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Documents $documents): bool
    {
        //
        if($user->hasPermissionTo('View Documents')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        if($user->hasPermissionTo('Create Documents')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Documents $documents): bool
    {
        //
        if($user->hasPermissionTo('Update Documents')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Documents $documents): bool
    {
        //
        if($user->hasPermissionTo('Delete Documents')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Documents $documents)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Documents $documents)
    {
        //
    }
}
