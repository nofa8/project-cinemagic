<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewBusinessRelated(User $user): bool
    {
        return $user->type == 'A'||$user->type=='E';
    }
    public function viewAdminRelated(User $user): bool
    {
        return $user->type == 'A';
    }

    
}
