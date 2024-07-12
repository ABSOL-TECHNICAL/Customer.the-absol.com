<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\AccountType;
use App\Models\User;

class AccountTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        if($user->hasRole(['Admin']) ){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AccountType $accountType)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AccountType $accountType)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AccountType $accountType)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AccountType $accountType)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AccountType $accountType)
    {
        //
    }
}
