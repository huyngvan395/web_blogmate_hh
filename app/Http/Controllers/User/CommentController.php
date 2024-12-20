<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

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
        return response()->json(['status'=>'Thành công', 'comment' => $comment]);
    }
}
