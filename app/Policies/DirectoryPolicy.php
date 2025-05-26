<?php

namespace App\Policies;

use App\User;
use App\Directory;
use Illuminate\Auth\Access\HandlesAuthorization;

class DirectoryPolicy
{
    use HandlesAuthorization;

    /**
     * @param  \App\User  $user
     * @param  mixed      $ability
     * @return mixed
     */
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Directory  $directory
     * @return mixed
     */
    public function view(User $user, Directory $directory)
    {
        return $user->id == $directory->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Directory  $directory
     * @return mixed
     */
    public function update(User $user, Directory $directory)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Directory  $directory
     * @return mixed
     */
    public function delete(User $user, Directory $directory)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Directory  $directory
     * @return mixed
     */
    public function restore(User $user, Directory $directory)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Directory  $directory
     * @return mixed
     */
    public function forceDelete(User $user, Directory $directory)
    {
        //
    }
}
