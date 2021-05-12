<?php

namespace App\Contracts;

use App\Models\User;

interface Ownable
{
    /**
     * Does a user own this object.
     *
     * @param \App\Models\User $user
     * @return boolean
     */
    public function isOwner(User $user): bool;
}
