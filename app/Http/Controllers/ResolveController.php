<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Issue;
use App\Models\Resolve;
use App\Models\User;
use App\Models\ExtendRequest;
use App\Models\IssueResolve;
use App\Models\Winner;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResolveController extends Controller
{
    public function index()
    {
        $resolves = Resolve::latest()->get(); 
        foreach($resolves as $resolve)
        {
            $resolve->user = $resolve->user;
            $resolve->winner = $resolve->winner;
            $resolve->issue = $resolve->issue;
            $resolve->bid = $resolve->bid;
        }       
        return view('resolves.index', compact('resolves'));
    }

    public function create()
    {
        $issues = Issue::all();
        $users = User::all();
        return view('resolves.create', compact('issues', 'users'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        $data = $request->all();
        $resolve = Resolve::create([
            'user_id' => $data['user_id'] ?? null,
            'bid_id' => $data['bid_id'] ?? null,
            'issue_id' => $data['issue_id'] ?? null,
            'winner_id' => $data['winner_id'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'submission_date' => $data['submission_date'] ?? null,
            'extension_count' => $data['extension_count'] ?? 0,
            'extended_date' => $data['extended_date'] ?? null,
        ]);

        return redirect()->route('resolves.index')->withMessage('Successfully Created');
    }

    public function delete($resolve_id)
    {
        $resolve = Resolve::where('id', $resolve_id)->first()->delete();
        return redirect()->route('resolves.index')->withMessage('Successfully deleted');
    }

    public function resolvingNow($user_id)
    {
        // dd("Ok");
        $resolvingNow = Resolve::where('user_id', $user_id)->first();
        
        if(!isset($resolvingNow))
        {
             return view('resolves.not-resolving-anything');
        }    
        if($resolvingNow->received_date){
            $resolvingNow->submission_date = Carbon::parse($resolvingNow->submission_date); 
            $resolvingNow->received_date = Carbon::parse($resolvingNow->received_date);
        }    
        $requests = ExtendRequest::where('resolve_id', $resolvingNow->id)->get();
        return view('resolves.resolving-now', compact('resolvingNow', 'requests'));
    }

    public function extendRequest(Request $request)
    {
        $resolvingNow = Resolve::where('id', $request->resolve_id)->firstOrFail();   
        $resolvingNow->reason=$request->reason;
        $resolvingNow->update();

        $Request = ExtendRequest::create([
            'reason' => $request->reason ?? null, 
            'resolve_id' => $request->resolve_id ?? null,
            'user_id' => $resolvingNow->user_id ?? null,
            'issue_id' => $resolvingNow->issue_id ?? null
        ]);

        return redirect()->route('resolving_now', ['user_id' => auth()->user()->id])->withMessage("Successfully Submitted");
    }

    public function timeExtendRequest()
    {
       $requests = ExtendRequest::where('approved', 0)->latest()->get();
       return view('resolves.time-extend-request', compact('requests'));
    }

    public function approveRequest($resolve_id, $request_id)
    {
        $resolve = Resolve::where('id', $resolve_id)->firstOrFail();
        $submissionDate = Carbon::parse($resolve->submission_date);
        $newSubmissionDate = $submissionDate->addDay()->format('Y-m-d');

        $resolve->submission_date = $newSubmissionDate;
        $resolve->extension_count += 1;
        $resolve->update();

        $request = ExtendRequest::where('id', $request_id)->firstOrFail();
        $request->approved = 1;
        $request->update();

        return redirect()->route('resolves.timeExtendRequest')->withMessage("Successfully Approved");
    }

    public function rejectRequest($resolve_id, $request_id)
    {
        dd($resolve_id);
    }

    public function completeTask(Request $request)
    {
        //dd($request->all());
        $resolve = Resolve::where('id', $request->resolve_id)->firstOrFail();

        //change issue status
        $issue = Issue::where('id', $resolve->issue_id)->firstOrFail();
        $issue->status = 'done';
        $issue->solve_note = $request->solveNote;
        $issue->update();
        
        //make history
        $history = IssueResolve::create([
            'user_id' => $resolve->user_id ?? null,
            'issue_id' => $resolve->issue_id ?? null,
            'bid_id'   => $resolve->bid_id ?? null,
            'extension_count' => $resolve->extension_count ?? null,
            'submission_date'  => $resolve->submission_date ?? null,
        ]);

        //make history
        //empty resolves table
        $resolve->delete();
        return redirect()->route('issues.mySolved', ['user_id' => auth()->user()->id])->withMessage("Congratulations! Successfully Completed!");
    }

    public function giveup(Request $request)
    {
        $resolve = Resolve::where('id', $request->resolve_id)->first();
        $winner = Winner::where('id', $resolve->winner_id)->first();
        $winners = Winner::where('issue_id', $winner->issue_id)->get();

        if(count($winners) > 1)
        {
            if($winner->position < 3)
            {
                $nextWinner = $winners->where('position', ($winner->position + 1))->first();
                if($nextWinner)
                {
                    $user = User::where('id', $nextWinner->bid->user_id)->first();
                    $howManyResolvingNow = Resolve::where('user_id', $user->id)->get()->count();
                    if($howManyResolvingNow > 0){
                        $doesUserWantToTakeMore = User::where('id', $nextWinner->bid->user_id)->first()->up_for_more;
                        if($doesUserWantToTakeMore == 1)
                        {
                            $this->makeResolve($nextWinner, $request);                            
                        }else{
                            $nextWinner = $winners->where('position', ($winner->position + 2))->first();
                            if($nextWinner)
                            {
                                $user = User::where('id', $nextWinner->bid->user_id)->first();
                                $howManyResolvingNow = Resolve::where('user_id', $user->id)->get()->count();
                                if($howManyResolvingNow > 0)
                                {
                                    $doesUserWantToTakeMore = User::where('id', $nextWinner->bid->user_id)->first()->up_for_more;
                                    if($doesUserWantToTakeMore == 1)
                                    {
                                        $this->makeResolve($nextWinner, $request);
                                    }else{
                                        //haven't fixed yet
                                        $issue = Issue::where('id', $nextWinner->issue_id)->first();
                                        $issue->status = 'needForceAssign';
                                        $issue->update();
                                    }
                                }else{
                                    $this->makeResolve($nextWinner, $request);
                                }
                            }else{
                                //notification
                                //force assign
                                $issue = Issue::where('id', $nextWinner->issue_id)->first();
                                $issue->status = 'needForceAssign';
                                $issue->shipper_id = $resolve->user_id;
                                $issue->update();
                            }
                        }
                    }else{
                        $this->makeResolve($nextWinner, $request);
                    }
                    
                    //notification
                }else{
                    //notification
                    //force
                    $resolve->delete();
                    $issue = Issue::where('id', $nextWinner->issue_id)->first();
                    $issue->status = 'needForceAssign';
                    $issue->shipper_id = $resolve->user_id;
                    $issue->update();
                }
            }else{
                //notification
                //force assign
                $issue = Issue::where('id', $resolve->issue_id)->first();
                $issue->status = 'needForceAssign';
                $issue->shipper_id = $resolve->bid->user_id;
                $issue->update();
            }
        }

        $bid = $resolve->bid;
        $bid->status = 'Passed';
        $bid->update();
        $resolve->delete();

        return redirect()->route('issues.biddableIssues')->withMessage('Nice try...! Want to try another one?');
    }

    public function ship($issue_id)
    {
        $resolve = Resolve::where('issue_id', $issue_id)->first();
        $resolve->shipped_date = Carbon::now();
        $resolve->update();

        return redirect()->route('issues.toShip', ['user_id' => auth()->user()->id])->withMessage("Successfully updated");
    }

    public function receive($resolve_id)
    {
        $resolve = Resolve::where('id', $resolve_id)->first();
        $resolve->received_date = Carbon::now();
        $sendBack = Carbon::parse($resolve->bid->sendBackDate);
        $bidCreateDate = $resolve->bid->created_at;
        $dateDiff = $bidCreateDate->diffInDays($sendBack) + 1;
        $submission_date = $resolve->received_date->addDay($dateDiff);
        $resolve->submission_date = $submission_date->format('Y-m-d');
        $resolve->received_date = $resolve->received_date->format('Y-m-d');
        $resolve->update();

        $issue = Issue::where('id', $resolve->issue_id)->first();
        $issue->status = 'running';
        $issue->update();

        return redirect()->route('resolving_now', ['user_id' => auth()->user()->id]);
    }

    public function makeResolve($nextWinner, $request)
    {
        dd($nextWinner);
        $shipper = Resolve::where('id', $request->resolve_id)->first()->user_id;
        $newResolve = Resolve::create([
                        'user_id' => $nextWinner->bid->user_id ?? null,
                        'bid_id'  => $nextWinner->bid_id ?? null,
                        'issue_id' => $nextWinner->issue_id ?? null,
                        'winner_id' => $nextWinner->id ?? null,
                        'previous_resolve_note' => $request->previous_resolve_note ?? null,
                        'shipper_id' => $shipper
                    ]);
        
        $newResolve->update();

        $issue = Issue::where('id', $newResolve->issue_id)->first();
        $issue->status = 'assigned';
        $issue->update();
    }

    public function forceAssign($issue_id)
    {
        $issue = Issue::where('id', $issue_id)->first();
        $users = User::all();
        $bids = Bid::where('issue_id', $issue_id)->get();
        foreach($bids as $bid)
        {
            $bid->assigned = Resolve::where('user_id', $bid->user->id)->get()->count();
            $bid->up_for_more = User::where('id', $bid->user->id)->first()->up_for_more;
        }
        return view('resolves.create-force-assign', compact('issue', 'users', 'bids'));
    }
}
