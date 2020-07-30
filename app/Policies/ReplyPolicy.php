<?php

namespace App\Policies;

use App\User;
use App\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user,Reply $reply)
    {
        return $user->id==$reply->user_id;
    }

    public function delete(User $user,Reply $reply)
    {
        return $user->id==$reply->user_id;
    }
}
