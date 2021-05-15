<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function updating(User $user)
    {
        Cache::tags(['users'])->forget("user-{$user->id}");
    }

    public function deleting(User $user)
    {
        Cache::tags(['users'])->forget("user-{$user->id}");
    }
}
