<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Log;

class DashboardPolicy
{
    public function access(User $user)
    {
        return in_array($user->role, ['admin', 'superadmin']);
    }
}
