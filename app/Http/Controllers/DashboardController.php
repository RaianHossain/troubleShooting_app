<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendingEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.dashboard');
    }
    
    public function sendEmail()
    {
        $data = array(
            'name' => "raiansanil@gmail.com",
            'message' => "test message"
        );

        Mail::to('raiansanil@gmail.com')->send(new sendingEmail($data));
        return back()->with('success', 'Thanks for contacting us!');
        dd("sent");
    }
}
