<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Discipline;

class DisciplinePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Discipline $discipline): bool
    {
        return true;
    }

    public function viewMy(User $user): bool
    {
        return $user->type == 'T' || $user->type == 'S';
    }

    public function create(User $user): bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function update(User $user, Discipline $discipline): bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function delete(User $user, Discipline $discipline): bool
    {
        return $user->admin || $user->type == 'A';
    }
}
