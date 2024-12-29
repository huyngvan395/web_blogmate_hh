<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query=$request->input('query');
        $blogResults = Blog::search($query)->get()->map(function ($blog) {
            $blog->hash_id = Crypt::encryptString($blog->id);
            return $blog;
        });

        $userResults = User::search($query)->get()->where('role', '!=', 'admin');

        return response()->json(['blog' => $blogResults, 'user' => $userResults]);
    }

    public function show(Request $request) 
    {
        $query=$request->input('query');
        $blogResults = Blog::search($query)->get()->map(function ($blog) {
            $blog->hash_id = Crypt::encryptString($blog->id);
            return $blog;
        });

        $userResults = User::search($query)->get()->where('role', '!=', 'admin');

        return view('user.search_page', compact('blogResults', 'query'));
    }

    public function showBlog(Request $request)
    {
        $query=$request->input('query');
        $blogResults = Blog::search($query)->get()->map(function ($blog) {
            $blog->hash_id = Crypt::encryptString($blog->id);
            return $blog;
        });
        return view('user.search_page', compact('blogResults', 'query'));
    }

    public function showUser(Request $request)
    {
        $query=$request->input('query');
        $userResults = User::search($query)->get()->where('role', '!=', 'admin');
        return view('user.user_search_page', compact('userResults', 'query'));
    }
}
