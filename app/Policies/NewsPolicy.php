<?php

namespace App\Policies;

use App\News;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
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
     * Determine whether the user can view the news.
     *
     * @return mixed
     */
    public function view(User $user, News $news)
    {
        return $user->id == $news->created_by_id;
    }

    /**
     * Determine whether the user can create news.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the news.
     *
     * @return mixed
     */
    public function update(User $user, News $news)
    {
        //
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @return mixed
     */
    public function delete(User $user, News $news)
    {
        //
    }

    /**
     * Determine whether the user can restore the news.
     *
     * @return mixed
     */
    public function restore(User $user, News $news)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the news.
     *
     * @return mixed
     */
    public function forceDelete(User $user, News $news)
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
