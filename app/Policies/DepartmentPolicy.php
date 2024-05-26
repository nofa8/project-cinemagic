<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Department;

class DepartmentPolicy
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

    public function view(User $user, Department $department): bool
    {
        // User is authenticated ($user != null)
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Department $department): bool
    {
        return false;
    }

    public function delete(User $user, Department $department): bool
    {
        return false;
    }
}
