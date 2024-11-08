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

    public function makeNotification(Request $request)
    {
        if($request['subscriber'] == 'all'){
            $users = User::all();
            $subscribers = array();
            foreach($users as $user)
            {
                $subscribers[$user->id] = "unseen";
            }
        }
        $notification = Notification::create([
            'message' => $request->message,
            'subscriber' => serialize($subscribers),
            'url' => $request->url
        ]);
        return response()->json($notification);
    }

    public function makeSeen($notification_id, $user_id)
    {
        $notification = Notification::where('id', $notification_id)->first();
        $subscribers = unserialize($notification->subscriber);
        $subscribers[$user_id] = 'seen';
        $notification->subscriber = serialize($subscribers);
        $notification->update();
        return 'success';
    }

    public function allNotifications()
    {
        // Get all notifications in descending order, with simple pagination
        $allNotifications = Notification::orderBy('id', 'DESC')->get();

        // Filter notifications for the current user
        $notifications = $allNotifications->filter(function ($notification) {
            $subscribers = unserialize($notification->subscriber);
            return in_array(auth()->user()->id, array_keys($subscribers));
        })->values(); // Reset keys to avoid gaps

        // Manually paginate the filtered collection
        $page = request()->get('page', 1);
        $perPage = 10;
        $paginatedNotifications = new \Illuminate\Pagination\LengthAwarePaginator(
            $notifications->forPage($page, $perPage),
            $notifications->count(),
            $perPage,
            $page,
            ['path' => request()->url()]
        );

        return view('dashboard.all-notifications', compact('paginatedNotifications'));
    }


    
}
