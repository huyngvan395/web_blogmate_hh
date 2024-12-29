<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        $comment=new Comment();
        $comment->blog_id=$request->input('blog_id');
        $comment->user_id=$request->input('user_id');
        $comment->content=$request->input('content');
        $comment->save();
        $comment->load('user');
        $comment->heart_by_current_user = $comment->usersWhoHearts->contains(Auth::id());
        $comment->hearted_count = $comment->usersWhoHearts->count();
        return response()->json(['status'=>'Thành công', 'comment' => $comment]);
    }

    public function reply(Request $request)
    {
        $comment=new Comment();
        $comment->blog_id=$request->input('blog_id');
        $comment->user_id=$request->input('user_id');
        $comment->reply_id=$request->input('comment_id');
        $comment->content=$request->input('content');
        $comment->save();
        $comment->load('user','replyTo.user');
        $comment->heart_by_current_user = $comment->usersWhoHearts->contains(Auth::id());
        $comment->hearted_count=$comment->usersWhoHearts->count();
        return response()->json(['status'=>'Thành công', 'reply' => $comment]);
    }

}
