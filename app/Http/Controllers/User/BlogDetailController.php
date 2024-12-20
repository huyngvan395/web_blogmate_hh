<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class BlogDetailController extends Controller
{

    public function show($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $commentCount=Blog::find($id)->comment->count();
        $blog = Blog::with(['comment' => function ($query) {
            $query->whereNull('reply_id')->paginate(10); 
        }, 'comment.user','comment.usersWhoHearts'])->findOrFail($id);
        foreach ($blog->comment as $comment) {
            $comment->hearted_by_current_user = $comment->usersWhoHearts->contains(Auth::id());
            $comment->hearted_count=$comment->usersWhoHearts->count();
            $comment->replies_count=$comment->totalReplies();
        }
        $othersBlog = Blog::where('id', '!=', $blog->id)->where('user_id', $blog->user_id)->latest()->take(4)->get();
        return view('user.blog_detail', compact('blog','commentCount', 'othersBlog'));
    }

    public function fetchComments(Request $request)
    {
        $blogID=$request->input('blog_id');
        $page=$request->input('page');
        $comments=Comment::with(['user'])->where('blog_id',$blogID)->whereNull('reply_id')->paginate(10, ['*'], 'page', $page);
        foreach ($comments as $comment) {
            $comment->hearted_by_current_user = $comment->usersWhoHearts->contains(Auth::id());
            $comment->hearted_count=$comment->usersWhoHearts->count();
            $comment->replies_count=$comment->totalReplies();
        }
        if($comments->onLastPage()){
            $lastPage= true;
        }
        return response()->json(['comments'=>$comments,'lastPage'=>$lastPage]);
    }

    public function fetchReplies(Request $request)
    {
        $commentID=$request->input('comment_id');
        $page=$request->input('page');
        $replies=Comment::with(['user', 'replyTo.user'])->where('reply_id', $commentID)->paginate(10, ['*'], 'page', $page);
        foreach($replies as $reply){
            $reply->heart_by_current_user = $reply->usersWhoHearts->contains(Auth::id());
            $reply->hearted_count=$reply->usersWhoHearts->count();
            $reply->replies_count=$reply->totalReplies();
        }
        if($replies->onLastPage()){
            $lastPage= true;
        }
        return response()->json(['replies'=>$replies, 'lastPage'=>$lastPage]);
    }

}
