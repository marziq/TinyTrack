<?php

namespace App\Policies;

use App\Models\Baby;
use App\Models\User;


class BabyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Baby $baby)
    {
        return $user->id === $baby->user_id;
    }

    public function update(User $user, Baby $baby)
    {
        return $user->id === $baby->user_id;
    }

    public function delete(User $user, Baby $baby)
    {
        return $user->id === $baby->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Baby $baby): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Baby $baby): bool
    {
        return false;
    }


}
