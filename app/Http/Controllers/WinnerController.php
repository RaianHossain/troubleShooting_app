<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Issue;
use App\Models\Notification;
use App\Models\Resolve;
use App\Models\Winner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    public function index()
    {
        $winners = Winner::latest()->get(); 
        foreach($winners as $winner)
        {
            $winner->issue = $winner->issue;
            $winner->bid = $winner->bid;
        }       
        return view('winners.index', compact('winners'));
    }

    public function create()
    {
        $issues = Issue::all();
        $bids = Bid::all();
        return view('winners.create', compact('issues', 'bids'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $winner = Winner::create([
            'endingAt' => $data['endingAt'] ?? null,
            'issue_id' => $data['issue_id'] ?? null,
            'bid_id' => $data['bid_id'] ?? null,
            'position' => $data['position'] ?? null,
            'extensionCount' => $data['extensionCount'] ?? 0,
            'extended_date' => $data['extended_date'] ?? null,
        ]);

        return redirect()->route('winners.index')->withMessage('Successfully Created');
    }

    public function delete($winner_id)
    {
        $winner = Winner::where('id', $winner_id)->first()->delete();
        return redirect()->route('winners.index')->withMessage('Successfully deleted');
    }

    public function assign($issue_id, $bid_id=null)
    {
        $winners = Bid::where('issue_id', $issue_id)->orderBy('score', 'DESC')->orderBy('id', 'ASC')->take(3)->get();
        if($bid_id == null)
        {
            $sl = 1;
            foreach($winners as $winner)
            {
                $newWinner = Winner::create([
                    'endingAt' => $winner->sendBackDate,
                    'issue_id' => $winner->issue_id,
                    'bid_id' => $winner->id,
                    'position' => $sl,
                    'extensionCount' => 0,
                ]);   
                if($sl == 1)
                {
                    $winner->sendBackDate = Carbon::parse($winner->sendBackDate);
                    Resolve::create([
                        'user_id'   =>  $winner->user_id,
                        'bid_id'   =>  $winner->id,
                        'issue_id'   =>  $winner->issue_id,
                        'winner_id'   =>  $newWinner->id,
                        // 'submission_date'   =>  $winner->sendBackDate->format('Y-m-d'),
                        'extension_count'  => 0,   
                        'shipper_id' => $winner->issue->user_id,                 
                    ]);
                }
                $sl++;
            }
        }else{
            $sl = 2;
            foreach($winners as $winner)
            {
                if($winner->id == $bid_id){
                    $newWinner = Winner::create([
                        'endingAt' => $winner->sendBackDate,
                        'issue_id' => $winner->issue_id,
                        'bid_id' => $winner->id,
                        'position' => 1,
                        'extensionCount' => 0,
                    ]);

                    $winner->sendBackDate = Carbon::parse($winner->sendBackDate);
                    Resolve::create([
                        'user_id'   =>  $winner->user_id,
                        'bid_id'   =>  $winner->id,
                        'issue_id'   =>  $winner->issue_id,
                        'winner_id'   =>  $newWinner->id,
                        // 'submission_date'   =>  $winner->sendBackDate->format('Y-m-d'),
                        'extension_count'  => 0, 
                        'shipper_id' => $winner->issue->user_id,                   
                    ]);
                }else{
                    $newWinner = Winner::create([
                        'endingAt' => $winner->sendBackDate,
                        'issue_id' => $winner->issue_id,
                        'bid_id' => $winner->id,
                        'position' => $sl,
                        'extensionCount' => 0,
                    ]);
                    $sl++;
                }
            }
        }
        

        $issue = Issue::where('id', $issue_id)->firstOrfail();
        $issue->status = 'assigned';
        $issue->update();
        

        return redirect()->route('issues.assignedIndex')->withMessage('Successfully Assigned');

    }
}
