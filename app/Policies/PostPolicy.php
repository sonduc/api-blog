<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAccess(['post.view']);
    }

    /**
     * Determine whether the user can create post.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(['post.create']);
    }

    /**
     * Determine whether the user can update the post
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasAccess(['post.update']);
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User $user
     *
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasAccess(['post.delete']);
    }
}
