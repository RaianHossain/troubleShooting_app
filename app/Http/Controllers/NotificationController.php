<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        if(count($notifications) > 0)
        {
            foreach($notifications as $notification)
            {
                $users = array();
                $subscribers = unserialize($notification->subscriber);
                // dd($notification->subscriber);
                foreach($subscribers as $subscriber)
                {
                    $temp = User::where('id', $subscriber)->first();
                    array_push($users, $temp);
                }
                $notification->subscriber = $users;
            }
        }
        // dd($notifications);
        return view('notifications.index', compact('notifications'));
    }
}
