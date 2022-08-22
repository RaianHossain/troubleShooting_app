<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendingEmail;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $allNotifications = Notification::orderBy('id', 'DESC')->simplePaginate(20);      
        $notifications = array();
        foreach($allNotifications as $allNotification)
        {
            $subscribers = unserialize($allNotification->subscriber);
            if(in_array(auth()->user()->id, array_keys($subscribers))){
                array_push($notifications, $allNotification);
            }
        }

        $notifications = (object) $notifications;
        // dd($notifications);
        return view('dashboard.dashboard', compact('notifications'));
    }
    
    public function sendEmail()
    {
       // return reponse()->json('check');
        $data = array(
            'issuerName' => "raiansanil@gmail.com",
            'url' => "test message"
        );

        Mail::to('jannat.bubtcse@gmail.com')->send(new sendingEmail($data));
       // return back()->with('success', 'Thanks for contacting us!');
        //dd("sent");
    }
}
