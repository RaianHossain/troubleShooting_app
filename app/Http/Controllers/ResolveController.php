<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Resolve;
use App\Models\User;
use App\Models\ExtendRequest;
use App\Models\IssueResolve;
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
        $resolvingNow = Resolve::where('user_id', $user_id)->firstOrFail();    
        
        $resolvingNow->submission_date = Carbon::parse($resolvingNow->submission_date);  
        $resolvingNow->created_at = Carbon::parse($resolvingNow->created_at);  

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
        dd($request->all());
        $resolve = Resolve::where('id', $request->resolve_id)->firstOrFail();

        //change issue status
        $issue = Issue::where('id', $resolve->issue_id)->firstOrFail();
        $issue->status = 'done';
        $issue->solve_note = $request->solveNote;
        // $issue->update();
        
        //make history
        // $history = IssueResolve::create([
        //     'user_id' => $resolve->user_id ?? null,
        //     'issue_id' => $resolve->issue_id ?? null,
        //     'bid_id'   => $resolve->bid_id ?? null,
        //     'extension_count' => $resolve->extension_count ?? null,
        //     'submission_date'  => $resolve->submission_date ?? null,
        // ]);

        //empty resolves table
        // $resolve->delete();
        

    }
}
