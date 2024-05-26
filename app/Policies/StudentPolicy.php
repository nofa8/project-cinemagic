<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->admin) {
            return true;
        }
        // When "Before" returns null, other methods (eg. viewAny, view, etc...) will be
        // used to check the user authorizaiton
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->type == 'T' || $user->type == 'A';
    }

    public function viewMy(User $user): bool
    {
        return $user->type == 'T';
    }

    public function view(User $user, Student $student): bool
    {
        if ($user->type == 'A' || ($user->type == 'S' && $user->id == $student->user_id)) {
            return true;
        }
        // If user is teacher, then he can view the detail information of his students only
        if ($user->type == 'T') {
            // ID set of disciplines that user teaches:
            $disciplinesOfTeacherSet = $user->teacher->disciplines->pluck('id')->toArray();
            // ID set of disciplines that the student is enrolled:
            $disciplinesOfStudentSet = $student->disciplines->pluck('id')->toArray();
            return count(array_intersect($disciplinesOfTeacherSet, $disciplinesOfStudentSet)) >= 1;
        }
        return false;
    }


    // Alternative code for the method view:
    // public function view(User $user, Student $student): bool
    // {
    //     if ($user->type == 'A' || ($user->type == 'S' && $user->id == $student->user_id)) {
    //         return true;
    //     }
    //     // If user is teacher, then he can view the detail information
    //     // of his students only
    //     if ($user->type == 'T') {
    //         // ID set of disciplines that he teaches:
    //         $disciplinesOfTeacherSet = $user->teacher->disciplines->pluck('id')->toArray();
    //         // Total disciplines of the student that are in the same set as the disciplines that he teaches
    //         $total = $student->disciplines()->whereIntegerInRaw('id', $disciplinesOfTeacherSet)->count();
    //         return  $total >= 1;
    //     }
    //     return false;
    // }

    public function create(User $user): bool
    {
        return $user->type == 'A';
    }

    public function update(User $user, Student $student): bool
    {
        return $user->type == 'A' || ($user->type == 'S' && $user->id == $student->user_id);
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->type == 'A';
    }
    }
