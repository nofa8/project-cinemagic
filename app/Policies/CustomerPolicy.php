<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    public function before(?User $user, string $ability): bool|null
    {
        if ($user?->type == 'A') {
            return true;
        }
        // When "Before" returns null, other methods (eg. viewAny, view, etc...) will be
        // used to check the user authorizaiton
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->type == 'A';
    }

    public function viewMy(User $user): bool
    {
        return $user->type == 'C';
    }

    public function view(User $user, Customer $customer): bool
    {
        if ($user->type == 'A' || ($user->type != 'A' && $user->id == $customer->user_id)) {
            return true;
        }
        return false;
    }


    // Alternative code for the method view:
    // public function view(User $user, Customer $customer): bool
    // {
    //     if ($user->type == 'A' || ($user->type == 'S' && $user->id == $customer->user_id)) {
    //         return true;
    //     }
    //     // If user is teacher, then he can view the detail information
    //     // of his Customers only
    //     if ($user->type == 'T') {
    //         // ID set of disciplines that he teaches:
    //         $disciplinesOfTeacherSet = $user->teacher->disciplines->pluck('id')->toArray();
    //         // Total disciplines of the Customer that are in the same set as the disciplines that he teaches
    //         $total = $customer->disciplines()->whereIntegerInRaw('id', $disciplinesOfTeacherSet)->count();
    //         return  $total >= 1;
    //     }
    //     return false;
    // }

    public function create(User $user): bool
    {
        return $user->type == 'A';
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->type == 'A' || ($user->type != 'A' && $user->id == $customer->user_id);
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $user->type == 'A';
    }
    }
