<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showBlogReport()
    {
        return view('admin.blog_report');
    }

    public function showCommentReport()
    {
        return view('admin.comment_report');
    }

    
}
