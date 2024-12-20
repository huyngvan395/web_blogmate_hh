<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show()
    {
        $blogs=Blog::all();
        return view('admin.blog', compact('blogs'));
    }

    public function delete(Request $request)
    {
        $id=$request->input('blogID');
        $blog=Blog::find($id);
        $blog->delete();
        return response()->json(['msg' => 'Thành công']);
    }
}
