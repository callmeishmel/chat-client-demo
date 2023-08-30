<?php

namespace App\Http\Controllers;

use App\User;
use App\Events\UserOnline;
use Illuminate\Http\Request;

class UserIdleController extends Controller
{
    public function setUserIdle(User $user)
    {
        $user->active = false;
        $user->save();
    }

    public function setUserActive(User $user)
    {
        $user->active = true;
        $user->save();
    }
}
