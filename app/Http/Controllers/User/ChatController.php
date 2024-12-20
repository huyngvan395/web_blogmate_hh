<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $userTargetID=$request->input('userTargetID',null);
        return view('user.chat',[
            'userTargetID' => $userTargetID
        ]);
    }
}
