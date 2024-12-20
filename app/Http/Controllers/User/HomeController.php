<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show()
    {
        $userCount=User::all()->count();
        $blogCount=Blog::all()->count();

        return view('user.home', compact('userCount','blogCount'));
    }
}
