<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function viewAny()
    {
        return true;
    }


    public function update(User $user,Post $post)
    {
        return $user->id==$post->user_id;
    }

    public function delete(User $user,Post $post)
    {
        return $user->id==$post->user_id;
    }

    public function view(User $user,Post $post)
    {
        return $user->id==$post->user_id;
    }

    public function create()
    {
        return true;
    }

    public function rate(User $user,Post $post)
    {
        return $user->id!=$post->user_id;
    }

    public function save(User $user,Post $post)
    {
        return $user->id!=$post->user_id;
    }



}
