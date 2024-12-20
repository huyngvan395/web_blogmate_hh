<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        $blogs=Blog::all();

        $usersWithMostFollowers = User::where('id','!=', Auth::user()->id)->where('role','!=','admin')
            ->with(['followers'])
            ->withCount('followers')
            ->orderBy('followers_count', 'desc')
            ->take(8)
            ->get()
            ->map(function ($user) {
                $user->is_followed = Auth::user()->following->contains($user->id);
                return $user;
            });

        return view('user.blog',compact('blogs','usersWithMostFollowers'));
    }
}
