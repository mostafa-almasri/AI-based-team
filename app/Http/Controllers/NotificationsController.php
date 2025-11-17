<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('member.notification', compact('notifications'));
    }



    public function markAllAsRead()
{
    Notification::where('user_id', Auth::id())->where('is_read', false)->update(['is_read' => true]);
    return response()->json(['success' => true]);
}

}
