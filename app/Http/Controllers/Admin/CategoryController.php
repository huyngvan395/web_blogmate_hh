<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show()
    {
        $categories=Category::all();
        return view('admin.category', compact('categories'));
    }

    public function showCreatePage()
    {
        return view("admin.create_category");
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'=>'unique:categories,name'
        ]);
        $name=$request->input('name');
        $category=new Category();
        $category->name=$name;
        $category->save();
        return redirect()->back()->with('success', 'Tạo danh mục thành công!');
    }

    public function delete(Request $request)
    {
        $id = $request->input('categoryID');
        $category=Category::find($id);
        $category->delete();
        return response()->json(['msg'=>'Thành công']);
    }
}
