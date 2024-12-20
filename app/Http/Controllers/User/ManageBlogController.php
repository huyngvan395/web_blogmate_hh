<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use function PHPUnit\Framework\isNull;

class ManageBlogController extends Controller
{

    public function upload(Request $request)
    {
        if($request->hasFile('file')) {
            $filenamewithextension = $request->file('file')->getClientOriginalName();

            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            $extension = $request->file('file')->getClientOriginalExtension();

            $filenametostore = $filename.'_'.time().'.'.$extension;

            $request->file('file')->storeAs('images/blog', $filenametostore,'public');

            $path = asset('storage/images/blog/'.$filenametostore);
    
            echo $path;
            exit;
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(['id', 'name']);
        return view('user.create_blog', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $blog=new Blog();
        $blog->title=$request->input('title');
        $blog->category_id = $request->input('category_id');
        $blog->content=$request->input('content');
        $blog->user_id=Auth::user()->id;
        $image_blog=$this->getFirstImgTag($request->input('content'));
        if(!empty($image_blog)){
            $blog->image_blog=$image_blog;
        }
        $blog->save();
        
        return redirect()->route('blog.blog-detail',['id' => Crypt::encryptString($blog->id)]);
    }

    private function getFirstImgTag($string) {
        $pattern = '/(?<!\s)<img\b[^>]*\bsrc=["\']([^"\']+)["\'][^>]*>/i';
    
        if (preg_match($pattern, $string, $matches)) {
            return $matches[1];
        }
        return null; 
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        
    }
}
