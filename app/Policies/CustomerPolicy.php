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
