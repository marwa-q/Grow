<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class DashboardPolicy
{
    public function access(User $user): bool
    {
        return in_array($user->role, ['admin', 'superadmin']);
    }
}
