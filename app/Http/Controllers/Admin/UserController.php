<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        $users=User::all();
        return view('admin.user',compact('users'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional avatar
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarName = md5($request->name) . '.' . $request->file('avatar')->getClientOriginalExtension();
            $avatarPath = $request->file('avatar')->storeAs('images/user', $avatarName, 'public'); 
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'avatar' => $avatarPath, 
        ]);

        return redirect()->back()->with('success', 'Tạo người dùng thành công!');
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
