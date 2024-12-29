<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class InfoUserController extends Controller
{
    public function show($infoUser)
    {

        $user = User::where('email', 'like', "$infoUser%")->first();

        return view('user.info_user', compact('user'));
    }

    public function showFollower($infoUser)
    {
        $user = User::with(['followers'])->where('email', 'like', "$infoUser%")->first();

        return view('user.follower', compact('user'));
    }

    public function showFollowing($infoUser)
    {
        $user = User::where('email', 'like', "$infoUser%")->first();

        return view('user.following', compact('user'));
    }
}
