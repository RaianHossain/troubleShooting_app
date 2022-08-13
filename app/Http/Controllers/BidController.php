<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Issue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function index()
    {
        $bids = Bid::latest()->get();    
        foreach($bids as $bid)
        {
            $bid->issue = $bid->issue;
            $bid->user = $bid->user;
        }    
        // dd($bids);
        return view('bids.index', compact('bids'));
    }

    public function showBids($issue_id)
    {
        $winners = Bid::where('issue_id', $issue_id)->orderBy('score', 'DESC')->orderBy('id', 'ASC')
        ->take(3)->get();
        $bids = Bid::where('issue_id', $issue_id)->latest()->get();
        foreach($bids as $bid)
        {
            $bid->user = $bid->user;
            $bid->issue = $bid->issue;
        }
        
        // dd($bids);
        return view('bids.index', compact('bids', 'winners'));
    }

    public function create()
    {
        $issues = Issue::all();
        $users = User::all();
        return view('bids.create', compact('issues', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $center = User::where('id', $data['user_id'])->first()->center->name;
        // dd($data);
        $bid = Bid::create([
            'user_id' => $data['user_id'],
            'issue_id' => $data['issue_id'],
            'center' => $center,
            'timeToFix' => $data['timeToFix'],
            'sendBackDate' => $data['sendBackDate'],
            'needSupport' => $data['needSupport'],
            'needSpare' => $data['needSpare'],
            'possibleCost' => $data['possibleCost'],
            'haveExistingTask' => $data['haveExistingTask']
        ]);

        //Score Calculation function
        $now= Issue::where('id', $data['issue_id'])->first()->created_at;
        $date=Carbon::parse($bid->sendBackDate);
        $days = $date->diffInDays($now);
        if($bid->haveExistingTask='yes')
        {
            $haveTask=5;
        }
        else{
            $haveTask=0;
        }
        $bid->score =($days*6)+$haveTask+($bid->possibleCost*4)+($bid->needSpare*3)
                    +($bid->timeToFix*2)+$bid->needSupport;
        $bid->update();

        return redirect()->route('bids.index')->withMessage('Successfully Created');
    }

    public function delete($bid_id)
    {
        $bid = Bid::where('id', $bid_id)->first()->delete();
        return redirect()->route('bids.index')->withMessage('Successfully deleted');
    }

    public function bidAnIssue($issue_id)
    {
        // dd($issue_id);
        $issue = Issue::where('id', $issue_id)->firstOrFail();
        return view('bids.bid-an-issue', compact('issue'));
    }

    public function bidStore(Request $request)
    {
       
        //dd($request->all());
        $bid = Bid::create([
            'issue_id'    => $request->issue_id,
            'user_id'     => auth()->user()->id,
            'center'      => auth()->user()->center->name,
            'timeToFix'    => $request->timeToFix,
            'sendBackDate'    => $request->sendBackDate,
            'needSupport'    => $request->needSupport,
            'needSpare'    => $request->needSpare,
            'possibleCost'    => $request->possibleCost,
            'haveExistingTask'    => $request->haveExistingTask,
        ]);

        //$bid->score = 100;
        //Score Calculation function
        $now= Issue::where('id', $request->issue_id)->first()->created_at;
        $date=Carbon::parse($request->sendBackDate);
        $days = $date->diffInDays($now);
        if($bid->haveExistingTask == 'yes')
        {
            $haveTask=5;
        }
        else{
            $haveTask=0;
        }
        $score = ($days*6)+$haveTask+($bid->possibleCost*4)+($bid->needSpare*3)
                    +($bid->timeToFix*2)+$bid->needSupport;
        //dd($score);
        $bid->score = $score;
        $bid->update();
        
        return redirect()->route('issues.myBidded', ['user_id' => auth()->user()->id])->withMessage("Successfully Bidded");
    }

    
}
