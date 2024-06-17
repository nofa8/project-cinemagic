<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Movie;

class MoviePolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type == 'A') {
            return true;
        }
        return null;
    }

    public function viewShowCase(?User $user): bool
    {
        return true;
    }

    public function viewCurriculum(?User $user): bool
    {
        return true;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(?User $user, Movie $movie): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Movie $movie): bool
    {
        return false;
    }

    public function delete(User $user, Movie $movie): bool
    {
        return false;
    }
}
