<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Course;

class CoursePolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->admin) {
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

    public function view(?User $user, Course $course): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Course $course): bool
    {
        return false;
    }

    public function delete(User $user, Course $course): bool
    {
        return false;
    }

}
