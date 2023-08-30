<?php

namespace App\Http\Controllers;

use App\User;
use App\Events\UserOffline;
use Illuminate\Http\Request;

class UserOfflineController extends Controller
{
    public function __invoke(User $user)
    {
        $user->status = 'offline';
        $user->save();

        broadcast(new UserOffline($user));
    }
}
