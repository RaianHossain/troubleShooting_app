<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;
use App\Models\IssueResolve;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\sendingEmail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $notifications = Notification::orderBy('id', 'DESC')
        ->get()
        ->filter(function ($notification) {
            $subscribers = unserialize($notification->subscriber);
            return in_array(auth()->user()->id, array_keys($subscribers));
        })
        ->take(4);

        // Fetch resolved issues per month for the current year
        $currentYear = Carbon::now()->year;
        $userId = auth()->user()->id;

        $issuesResolvedByMonth = IssueResolve::whereYear('submission_date', $currentYear)
            ->where('user_id', $userId)
            ->selectRaw('MONTH(submission_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        // Format the data for charting (fill missing months with 0)
        $chartData = [];
        for ($month = 1; $month <= 12; $month++) {
            $chartData[] = $issuesResolvedByMonth->get($month, 0);
        }
        
        //pie chart data
        $scoreDistribution = $this->getScoreDistribution();
        $pieChartNames = $scoreDistribution[0];
        $pieChartPercentages = $scoreDistribution[1];

        return view('dashboard.dashboard', compact('notifications', 'chartData', 'currentYear', 'pieChartNames', 'pieChartPercentages'));
    }
    
    public function sendEmail()
    {
       // return reponse()->json('check');
        $data = array(
            'subject' =>"New issue...",
            'issuerName' => "raiansanil@gmail.com",
            'url' => "test message"
        );

        Mail::to('raiansanil@gmail.com')->send(new sendingEmail($data));
       // return back()->with('success', 'Thanks for contacting us!');
        //dd("sent");
    }

    public function getScoreDistribution()
    {
        // Retrieve each user's total score and the overall score sum
        $scores = User::select('nickname', 'score')->get();
        $totalScore = $scores->sum('score');
        
        $names = [];
        $percentages = [];

        if($totalScore > 0) {
            // Calculate each user's score as a percentage of the total
            $scoreDistribution = $scores->map(function($user) use ($totalScore, &$names, &$percentages) {
                $user->percentage = ($user->score / $totalScore) * 100;   
                $names[] = $user->nickname;
                $percentages[] = $user->percentage;
                return $user;
            });        
        } else {
            $scoreDistribution = $scores->map(function($user) use (&$names, &$percentages) {
                $user->percentage = 0;
                $names[] = $user->nickname;
                $percentages[] = $user->percentage;
                return $user;
            });
        }
        return [$names, $percentages];
    }
}
