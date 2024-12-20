<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeartController extends Controller
{
    public function heartBlog(Request $request)
    {
        $blog_id=$request->input('blog_id');
        $blog=Blog::findOrFail($blog_id);
        $user_id=Auth::user()->id;
        if($blog->usersWhoHearts->contains($user_id)){
            $blog->usersWhoHearts()->detach($user_id);
            $blog->load('usersWhoHearts');
        }
        else{
            $blog->usersWhoHearts()->attach($user_id);
            $blog->load('usersWhoHearts');
        }
        return response()->json(['usersWhoHearts' => $blog->usersWhoHearts, 'heartCount'=> $blog->usersWhoHearts->count()]);
    }

    public function heartComment(Request $request)
    {
        $comment_id=$request->input('comment_id');
        $comment=Comment::findOrFail($comment_id);
        $user_id=Auth::user()->id;
        if($comment->usersWhoHearts->contains($user_id)){
            $comment->usersWhoHearts()->detach($user_id);
            $comment->load('usersWhoHearts');
        }else{
            $comment->usersWhoHearts()->attach($user_id);
            $comment->load('usersWhoHearts');
        }
        return response()->json(['usersWhoHearts'=> $comment->usersWhoHearts]);
    }
}
