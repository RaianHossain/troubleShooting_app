<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Issue;
use App\Models\Resolve;
use App\Models\User;
use App\Models\ExtendRequest;
use App\Models\IssueResolve;
use App\Models\Notification;
use App\Models\Winner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendingEmail;


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
        //dd($request->all());
        $data = $request->all();
        $resolve = Resolve::create([
            'user_id' => $data['user_id'] ?? null,
            'bid_id' => $data['bid_id'] ?? null,
            'issue_id' => $data['issue_id'] ?? null,
            'winner_id' => $data['winner_id'] ?? null,
            //'start_date' => $data['start_date'] ?? null,
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
        $resolvingsNow = Resolve::where('user_id', $user_id)->get();
        $allRequest = [];
        foreach($resolvingsNow  as $resolvingNow )
        {
            if(!isset($resolvingNow))
            {
                 return view('resolves.not-resolving-anything');
            }    
            if($resolvingNow->received_date){
                $resolvingNow->submission_date = Carbon::parse($resolvingNow->submission_date); 
                $resolvingNow->received_date = Carbon::parse($resolvingNow->received_date);
            }   
            $requests = ExtendRequest::where('resolve_id', $resolvingNow->id)->get();
            array_push($allRequest, $requests);
        }
       
        return view('resolves.resolving-now', compact('resolvingsNow', 'allRequest'));
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

        $subscribers[config('roleWiseId.super_admin')] = 'unseen';
        $notification = Notification::create([
            'message' => $resolvingNow->user->name.' requested for time extention of issue '.$resolvingNow->issue->code,
            'subscriber' => serialize($subscribers),
            'url' => env('APP_URL').'/resolves/time-extend-request'
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

        // $subscribers[$resolve->user_id] = 'unseen';
        // $notification = Notification::create([
        //     'message' => 'Your request for time extention of '.$resolve->issue->code.' is accepted',
        //     'subscriber' => serialize($subscribers),
        //     'url' => env('APP_URL').'/resolving-now/'.$resolve->user_id
        // ]); 

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

        //score penalty
        if($resolve->extension_count == 0)
        {
            $user = User::where('id', $resolve->user_id)->first();
            $user->score = $user->score+100;
        }

        else if($resolve->extension_count == 1)
        {
            $user = User::where('id',  $resolve->user_id)->first();
            $user->score = $user->score+75;
        }

        else if($resolve->extension_count == 2)
        {
            $user = User::where('id',  $resolve->user_id)->first();
            $user->score = $user->score+50;
        }

        else if($resolve->extension_count == 3)
        {
            $user = User::where('id',  $resolve->user_id)->first();
            $user->score = $user->score+10;
        }
        
        //make history
        $history = IssueResolve::create([
            'user_id' => $resolve->user_id ?? null,
            'issue_id' => $resolve->issue_id ?? null,
            'bid_id'   => $resolve->bid_id ?? null,
            'extension_count' => $resolve->extension_count ?? null,
            'submission_date'  => $resolve->submission_date ?? null,
        ]);

        //make notification
        $subscribers[$resolve->user_id] = 'unseen';
        $subscribers[config('roleWiseId.super_admin')] = 'unseen';

        $notification = Notification::create([
            'message' => 'Congratulations to '.$resolve->user->name.'for successfully completing the issue of code: '.$resolve->issue->code,
            'subscriber' => serialize($subscribers),
            'url' => env('APP_URL').'/my-solved/'.$resolve->user_id
        ]); 
        //empty resolves table
        $resolve->delete();
             
        $data = array(
            'subject' => "Task Completed",
            'url' => "",
            'message' =>  "Issue code {$resolve->issue->code} has been resolved completely!"
        );

        
        Mail::to(config('roleWiseId.super_admin_email'))->send(new sendingEmail($data));
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
                //dd( $nextWinner);

                if($nextWinner)
                {
                    $user = User::where('id', $nextWinner->bid->user_id)->first();
                    $howManyResolvingNow = Resolve::where('user_id', $user->id)->get()->count();
                    if($howManyResolvingNow > 0){
                        $doesUserWantToTakeMore = User::where('id', $nextWinner->bid->user_id)->first()->up_for_more;
                        if($doesUserWantToTakeMore == 1)
                        {
                            $newResolve = $this->makeResolve($nextWinner, $request);  
                            $this->makeResolveNotification($newResolve, $resolve); 
                            $this->sendResolveEmail($newResolve);
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
                                        $newResolve = $this->makeResolve($nextWinner, $request);
                                        $this->makeResolveNotification($newResolve, $resolve);
                                        $this->sendResolveEmail($newResolve);
                                    }else{
                                        //haven't fixed yet
                                        $issue = Issue::where('id', $nextWinner->issue_id)->first();
                                        $issue->status = 'needForceAssign';
                                        $issue->update();

                                        $this->makeForceAssignNotification($resolve);
                                        $this->sendForceAssignEmail($resolve);

                                    }
                                }else{
                                    $newResolve = $this->makeResolve($nextWinner, $request);
                                    $this->makeResolveNotification($newResolve, $resolve);
                                    $this->sendResolveEmail($newResolve);
                                }
                            }else{
                                //notification
                                //force assign
                                //dd($winners[0]);
                                $issue = Issue::where('id', $winners[0]->issue_id)->first();
                                $issue->status = 'needForceAssign';
                                $issue->shipper_id = $resolve->user_id;
                                $issue->update();

                                $this->makeForceAssignNotification($resolve);
                                $this->sendForceAssignEmail($resolve);
                            }
                        }
                    }else{
                        $newResolve= $this->makeResolve($nextWinner, $request);
                        $this->makeResolveNotification($newResolve, $resolve);
                        $this->sendResolveEmail($newResolve);
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

                    $this->makeForceAssignNotification($resolve);
                    $this->sendForceAssignEmail($resolve);
                }
            }else{
                //notification
                //force assign
                $issue = Issue::where('id', $resolve->issue_id)->first();
                $issue->status = 'needForceAssign';
                $issue->shipper_id = $resolve->bid->user_id;
                $issue->update();

                $this->makeForceAssignNotification($resolve);
                $this->sendForceAssignEmail($resolve);
            }
        }

        $bid = $resolve->bid;
        $bid->status = 'Passed';
        $bid->update();

        // $subscribers[config('roleWiseId.super_admin')] = 'unseen';
        // $subscribers[$resolve->user_id] = 'unseen';
        // $notification = Notification::create([
        //     'message' => 'Machine of issue code '.$resolve->issue->code.' has been shipped to '.$resolve->user->name.' - '.$resolve->user->center->city.' from '.$resolve->shipper->center->name.' at '.$resolve->shipped_date->format('d-M-Y'),
        //     'subscriber' => serialize($subscribers),
        //     'url' => '#'
        // ]);

        $resolve->delete();

   

        return redirect()->route('issues.biddableIssues')->withMessage('Nice try...! Want to try another one?');
    }

    public function makeForceAssignNotification($resolve)
    {
        $subscribers[config('roleWiseId.super_admin')] = 'unseen';
        $notification = Notification::create([
            'message' => $resolve->user->name.' gave up the issue '.$resolve->issue->code.'. Need force assign',
            'subscriber' => serialize($subscribers),
            'url' => env('APP_URL').'/issues/force-assign/issues'
        ]);
    }

    public function makeResolveNotification($newResolve, $resolve)
    {
        $subscribers[config('roleWiseId.super_admin')] = 'unseen';
        $subscribers[$newResolve->user_id] = 'unseen';

        $notification = Notification::create([
            'message' => 'Issue from '.$newResolve->issue->user->center->name.' code: '.$newResolve->issue->code.' has been assigned to '.$newResolve->user->name.' '.$resolve->user->name.' gave up',
            'subscriber' => serialize($subscribers),
            'url' => env('APP_URL').'/issues/force-assign/issues'
        ]);

        $anotherSubscriber[$resolve->user_id] = 'unseen';

        $anotherNotification = Notification::create([
            'message' => 'Please ship the machine of issue code: '.$newResolve->issue->code.'to '.$newResolve->user->name.', center: '.$newResolve->user->center->name.' city: '.$newResolve->user->center->name, 
            'subscriber' => serialize($anotherSubscriber),
            'url' => env('APP_URL').'/issues/items-to-ship/'.$resolve->user_id
        ]);
    }

    public function ship($issue_id)
    {
        $resolve = Resolve::where('issue_id', $issue_id)->first();
        $resolve->shipped_date = Carbon::now();
        $resolve->update();

        $subscribers[config('roleWiseId.super_admin')] = 'unseen';
        $subscribers[$resolve->user_id] = 'unseen';
        $notification = Notification::create([
            'message' => 'Machine of issue code '.$resolve->issue->code.' has been shipped to '.$resolve->user->name.' - '.$resolve->user->center->city.' from '.$resolve->shipper->center->name.' at '.$resolve->shipped_date->format('d-M-Y'),
            'subscriber' => serialize($subscribers),
            'url' => '#'
        ]);

        $data = array(
            'subject' => "Machine Shipped",
            'url' => "",
            'message' => 'Machine of issue code '.$resolve->issue->code.' has been shipped to '.$resolve->user->name.' - '.$resolve->user->center->city.' from '.$resolve->shipper->center->name.' at '.$resolve->shipped_date->format('d-M-Y')
        );

        Mail::to($resolve->user->email)->send(new sendingEmail($data));

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

        $subscribers[config('roleWiseId.super_admin')] = 'unseen';
        $subscribers[$resolve->shipper_id] = 'unseen';
        $notification = Notification::create([
            'message' => 'Machine of issue code '.$resolve->issue->code.' received by '.$resolve->user->name.' - '.$resolve->user->center->city.' at '.Carbon::parse($resolve->received_date)->format('d-M-Y').' shipped at '.Carbon::parse($resolve->shipped_date)->format('d-M-Y'),
            'subscriber' => serialize($subscribers),
            'url' => '#'
        ]); 

        $data = array(
            'subject' => "Machine Received",
            'url' => "",
            'message' => 'Machine of issue code '.$resolve->issue->code.' received by '.$resolve->user->name.' - '.$resolve->user->center->city.' at '.Carbon::parse($resolve->received_date)->format('d-M-Y').' shipped at '.Carbon::parse($resolve->shipped_date)->format('d-M-Y')
        );

        Mail::to($resolve->shipper->email)->send(new sendingEmail($data));
        return redirect()->route('resolving_now', ['user_id' => auth()->user()->id]);
    }

    public function makeResolve($nextWinner, $request)
    {
        // dd($nextWinner);
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

        return $newResolve;
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

    public function sendResolveEmail($newResolve)
    {
        $data = array(
            'subject' =>"Issue assigned",
            'url' => "",
            'message' => "The issue of issue code {$newResolve->issue->code} has been assigned to {$newResolve->user->name}"
        );

        Mail::to($newResolve->user->email)->send(new sendingEmail($data));
        Mail::to(config('roleWiseId.super_admin_email'))->send(new sendingEmail($data));
    }

    public function sendForceAssignEmail($resolve)
    {
        $data = array(
            'subject' =>"Force assign",
            'url' => "",
            'message' => "{$resolve->user->name} gave up on the issue of code {$resolve->issue->code} and no one found to assign this task. You need to force assign."
        );

        Mail::to(config('roleWiseId.super_admin_email'))->send(new sendingEmail($data));
    }
}
