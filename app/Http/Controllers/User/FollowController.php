<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        }

        return response()->json(['msg'=>$msg,'followed'=> $author->followers->contains($user_id)]);

    }
}
