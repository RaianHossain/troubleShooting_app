<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendingEmail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.dashboard');
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
