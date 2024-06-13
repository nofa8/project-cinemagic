<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Theater;
use SebastianBergmann\Type\TrueType;

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
        return true;
    }

    public function update(User $user, Theater $theater): bool
    {
        return true;
    }

    public function delete(User $user, Theater $theater): bool
    {
        return true;
    }
}
