<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Theater;

class TheaterPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->admin) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        // User is authenticated ($user != null)
        return true;
    }

    public function view(User $user, Theater $theater): bool
    {
        // User is authenticated ($user != null)
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Theater $theater): bool
    {
        return false;
    }

    public function delete(User $user, Theater $theater): bool
    {
        return false;
    }
}
