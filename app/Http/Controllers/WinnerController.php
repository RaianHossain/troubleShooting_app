<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Issue;
use App\Models\Winner;
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
}
