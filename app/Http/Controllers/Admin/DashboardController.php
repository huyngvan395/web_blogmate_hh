<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function show()
    {

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('m'));
        }

        $latestUsers = User::latest()->where('role','!=','admin')->take(8)->get();

        $latestBlogs = Blog::latest()->take(6)->get();

        $blogs = Blog::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get()
            ->map(function ($blog) {
                $blog->month = str_pad($blog->month, 2, '0', STR_PAD_LEFT);
                return $blog;
            });

        $users = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get()
            ->map(function ($user) {
                $user->month = str_pad($user->month, 2, '0', STR_PAD_LEFT); 
                return $user;
            });

        $blogsData = $months->map(function ($month) use ($blogs) {
            $blog = $blogs->firstWhere('month', $month);
            return [
                'month' => 'Tháng ' . $month,
                'count' => $blog ? $blog->count : 0, 
            ];
        });

        $usersData = $months->map(function ($month) use ($users) {
            $user = $users->firstWhere('month', $month);
            return [
                'month' => 'Tháng ' . $month,
                'count' => $user ? $user->count : 0, 
            ];
        });

        $allUsers= User::all();
        $allBlogs=Blog::all();

        return view('admin.dashboard', compact('blogsData', 'usersData', 'blogs', 'users', 'latestUsers',  'latestBlogs', 'allUsers', 'allBlogs'));
    }
}
