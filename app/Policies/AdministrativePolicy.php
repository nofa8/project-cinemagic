<?php

namespace App\Policies;

use App\Models\User;

class AdministrativePolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($ability == 'updateAdmin') {
            return null;
        }
        if ($user?->admin) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->type == 'A';
    }

    public function view(User $user, User $administrative): bool
    {
        return $user->type == 'A';
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, User $administrative): bool
    {
        return $user->type == 'A' && $user->id == $administrative->id;
    }

    public function createAdmin(User $user): bool
    {
        return $user->admin;
    }

    public function updateAdmin(User $user, User $administrative): bool
    {
        // Only update if is admin and not himself
        return $user->admin && $user->id != $administrative->id;
    }

    public function delete(User $user, User $administrative): bool
    {
        return false;
    }

}
