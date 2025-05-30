<?php

namespace App\Policies;

use App\Event;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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
     * Determine whether the user can view the event.
     *
     * @return mixed
     */
    public function view(User $user, Event $event)
    {
        return $user->id == $event->created_by_id;
    }

    /**
     * Determine whether the user can create events.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the event.
     *
     * @return mixed
     */
    public function update(User $user, Event $event)
    {
        //
    }

    /**
     * Determine whether the user can delete the event.
     *
     * @return mixed
     */
    public function delete(User $user, Event $event)
    {
        //
    }

    /**
     * Determine whether the user can restore the event.
     *
     * @return mixed
     */
    public function restore(User $user, Event $event)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the event.
     *
     * @return mixed
     */
    public function forceDelete(User $user, Event $event)
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
