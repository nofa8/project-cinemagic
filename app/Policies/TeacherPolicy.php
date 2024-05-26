<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;

class TeacherPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Teacher $teacher): bool
    {
        return true;
    }

    public function viewMy(User $user): bool
    {
        return $user->type == 'S';
    }

    public function create(User $user): bool
    {
        return $user->admin || $user->type == 'A';
    }

    public function update(User $user, Teacher $teacher): bool
    {
        return $user->admin || $user->type == 'A' || ($user->type == 'T' && $user->id == $teacher->user_id) ;
    }

    public function createAdmin(User $user): bool
    {
        return $user->admin;
    }

    public function updateAdmin(User $user, Teacher $teacher): bool
    {
        // Only update if is admin and not himself
        return $user->admin && $user->id != $teacher->user_id;
    }

    public function delete(User $user, Teacher $teacher): bool
    {
        return $user->admin || $user->type == 'A';
    }
}
