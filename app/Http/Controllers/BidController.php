<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Issue;
use App\Models\User;
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
        $bids = Bid::where('issue_id', $issue_id)->get();
        foreach($bids as $bid)
        {
            $bid->user = $bid->user;
            $bid->issue = $bid->issue;
        }
        return view('bids.index', compact('bids'));
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
        $bid->score = 100;
        $bid->update();

        return redirect()->route('bids.index')->withMessage('Successfully Created');
    }

    public function delete($bid_id)
    {
        $bid = Bid::where('id', $bid_id)->first()->delete();
        return redirect()->route('bids.index')->withMessage('Successfully deleted');
    }
}
