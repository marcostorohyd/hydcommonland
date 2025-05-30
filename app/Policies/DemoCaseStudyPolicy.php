<?php

namespace App\Policies;

use App\DemoCaseStudy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DemoCaseStudyPolicy
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
     * Determine whether the user can view the demo case study.
     *
     * @return mixed
     */
    public function view(User $user, DemoCaseStudy $demoCaseStudy)
    {
        return $user->id == $demoCaseStudy->created_by_id;
    }

    /**
     * Determine whether the user can create demo case studies.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the demo case study.
     *
     * @return mixed
     */
    public function update(User $user, DemoCaseStudy $demoCaseStudy)
    {
        //
    }

    /**
     * Determine whether the user can delete the demo case study.
     *
     * @return mixed
     */
    public function delete(User $user, DemoCaseStudy $demoCaseStudy)
    {
        //
    }

    /**
     * Determine whether the user can restore the demo case study.
     *
     * @return mixed
     */
    public function restore(User $user, DemoCaseStudy $demoCaseStudy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the demo case study.
     *
     * @return mixed
     */
    public function forceDelete(User $user, DemoCaseStudy $demoCaseStudy)
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
