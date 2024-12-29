<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications=Notification::with(['user'])->where('userTarget_id', Auth::user()->id)->get();

        return response()->json(['notifications' => $notifications]);
    }
}
