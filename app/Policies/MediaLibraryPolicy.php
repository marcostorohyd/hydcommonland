<?php

namespace App\Policies;

use App\MediaLibrary;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaLibraryPolicy
{
    use HandlesAuthorization;

    /**
     * @param  \App\User  $user
     * @param  mixed  $ability
     * @return mixed
     */
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the media library.
     *
     * @return mixed
     */
    public function view(User $user, MediaLibrary $mediaLibrary)
    {
        return $user->id == $mediaLibrary->created_by_id;
    }

    /**
     * Determine whether the user can create media libraries.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the media library.
     *
     * @return mixed
     */
    public function update(User $user, MediaLibrary $mediaLibrary)
    {
        //
    }

    /**
     * Determine whether the user can delete the media library.
     *
     * @return mixed
     */
    public function delete(User $user, MediaLibrary $mediaLibrary)
    {
        //
    }

    /**
     * Determine whether the user can restore the media library.
     *
     * @return mixed
     */
    public function restore(User $user, MediaLibrary $mediaLibrary)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the media library.
     *
     * @return mixed
     */
    public function forceDelete(User $user, MediaLibrary $mediaLibrary)
    {
        //
    }

    /**
     * Determine whether the user can update or delete events.
     *
     * @return mixed
     */
    public function updateDelete(User $user)
    {
        //
    }
}
