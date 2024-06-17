<?php

namespace App\Policies;

use App\Models\User;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function edit(User $user): bool
    {
        return $user->type == 'A' || $user->type == 'E';
    }
}
