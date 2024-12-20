<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        $users=User::all();
        return view('admin.user',compact('users'));
    }

    public function delete(Request $request)
    {
        $id=$request->input('userID');
        $user=User::find($id);
        $user->delete();
        return response()->json(['msg'=>'Thành công']);
    }

    public function showCreatePage()
    {
        return view('admin.create_user');
    }
}
