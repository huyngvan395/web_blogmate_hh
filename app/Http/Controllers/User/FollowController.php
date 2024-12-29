<?php

namespace App\Http\Controllers\User;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $author_id=$request->input('author_id');
        $author=User::findOrFail($author_id);
        $user_id=Auth::user()->id;
        if($author->followers->contains($user_id)){
            $author->followers()->detach($user_id);
            $author->load('followers');
            $msg="Đã bỏ follow";
        }
        else{
            $author->followers()->attach($user_id);
            $author->load('followers');
            $msg="Đã follow";
            $user=User::find($user_id);
            $link=route('user.info',['infoUser' => Str::before($user->email,'@')]);
            NotificationEvent::dispatch($user_id,'follow',$link,[$author->id]);
            $notification= new Notification();
            $notification->user_id=$user_id;
            $notification->type="follow";
            $notification->link_target=$link;
            $notification->userTarget_id=$author->id;
            $notification->save();
        }
        return response()->json(['msg'=>$msg,'followed'=> $author->followers->contains($user_id)]);
    }
}
