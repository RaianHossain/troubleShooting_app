<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Center;
use App\Models\Issue;
use App\Models\IssueResolve;
use App\Models\Notification;
use App\Models\Resolve;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendingEmail;

class IssueController extends Controller
{
    public function index()
    {
        // die();
        $issues = Issue::latest()->get();
        foreach($issues as $issue)
        {
            $issue->uploaded_by = User::where('id', $issue->user_id)->first() ?? null;
        }
       
        return view('issues.index', compact('issues'));
    }

    public function show($issue_id)
    {
        $issue = Issue::where('id', $issue_id)->first();
        return view('issues.show', compact('issue'));
    }

    public function pendingIndex()
    {
        $issues = Issue::where("status", "pending")->get();
        foreach($issues as $issue)
        {
            $issue->uploaded_by = User::where('id', $issue->user_id)->first() ?? null;
        }
        return view('issues.pending-index', compact('issues'));
    }

    public function runningIndex()
    {
        $issues = Issue::where("status", "running")->get();
        foreach($issues as $issue)
        {
            $issue->uploaded_by = User::where('id', $issue->user_id)->first() ?? null;
        }
        return view('issues.running-index', compact('issues'));
    }

    public function assignedIndex()
    {
        $issues = Issue::where("status", "assigned")->latest()->get();
        foreach($issues as $issue)
        {
            $issue->uploaded_by = User::where('id', $issue->user_id)->first() ?? null;
            $issue->to = Resolve::where('issue_id', $issue->id)->first()->user;
        }
        $base_url = env('APP_URL');
        return view('issues.assigned-index', compact('issues', 'base_url'));
    }

    public function doneIndex()
    {
        $issues = Issue::where("status", "done")->get();
        foreach($issues as $issue)
        {
            $issue->uploaded_by = User::where('id', $issue->user_id)->first() ?? null;
        }
        return view('issues.done-index', compact('issues'));
    }

    public function myUploaded($user_id)
    {
        $issues = Issue::where("user_id", $user_id)->get();
        foreach($issues as $issue)
        {
            $issue->uploaded_by = User::where('id', $issue->user_id)->first() ?? null;
        }
        return view('issues.my-uploaded', compact('issues'));
    }

    public function mySolved($user_id)
    {
        $resolveHistories = IssueResolve::where('user_id', $user_id)->get();
        $issues = array();
        foreach($resolveHistories as $resolveHistory)
        {
            array_push($issues, $resolveHistory->issue);
        }
        return view('issues.my-solved', compact('issues'));
    }

    public function myBidded($user_id)
    {
        $bids = Bid::where('user_id', $user_id)->get();
        $issues = array();
        foreach($bids as $bid)
        {
            array_push($issues, $bid->issue);
        }
        return view('issues.my-bidded', compact('issues'));
    }

    public function create()
    {
        $users = User::all();
        $centers = Center::all();
        return view('issues.create', compact('users', 'centers'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $issue = Issue::create([
            'user_id' => $data['user_id'],
            'alarm' => $data['alarm'],
            'occuring_time' => $data['occuring_time'],
            'problem_history' => $data['problem_history'],
            'description' => $data['description'],
            'steps_taken' => $data['steps_taken'],
            'status' => "pending",
            'center_id' => $data['center_id'],
        ]);

        $code = $this->generateIssueCode($issue, $data['center_id']);
        $issue->code = $code;        
        $issue->update();

        return redirect()->route('issues.index')->withMessage('Successfully Created');
    }

    public function delete($issue_id)
    {
        // dd($issue_id);
        $issue = Issue::where('id', $issue_id)->first()->delete();
        return redirect()->route('issues.index');
    }

    public function tasksToAssign()
    {
        $issuesTemp = Issue::where('status', 'pending')->get();
        $issues = array();
        foreach($issuesTemp as $issueTemp)
        {
            if(count($issueTemp->bids) > 0){
                array_push($issues, $issueTemp);
            }
        }
        // dd($issues);
        return view('issues.tasks-to-assign', compact('issues'));
    }

    public function uploadAnIssue()
    {
        // dd("UploadAnIssue");
        return view('issues.upload-an-issue');
    }

    public function biddableIssues()
    {
        $issues = Issue::where('status', 'pending')->latest()->get();
        // dd($issues);
        return view('issues.biddable-issues', compact('issues'));
    }

    public function upload(Request $request)
    {
        $issue = Issue::create([
            'user_id' => auth()->user()->id,
            'alarm'   => $request->alarm,
            'occuring_time'   => $request->occuring_time,
            'problem_history'   => $request->problem_history,
            'description'   => $request->description,
            'steps_taken'   => $request->steps_taken,
            'status' => 'pending',
            'center_id' => auth()->user()->center->id,

        ]);

        if($request->file('imageOne')){
            $file= $request->file('imageOne');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('Images/Issues'), $filename);
            $issue->imageOne = $filename;
        }
        if($request->file('imageTwo')){
            $file= $request->file('imageTwo');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('Images/Issues'), $filename);
            $issue->imageTwo = $filename;
        }
        if($request->file('imageThree')){
            $file= $request->file('imageThree');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('Images/Issues'), $filename);
            $issue->imageThree = $filename;
        }

        $code = $this->generateIssueCode($issue, null);
        $issue->code = $code;        
        $issue->update();
        
        //send users email about new issue
        // $users = User::get()->all();
        // $data = array(
        //     'issuerName' => auth()->user()->name,
        //     'url' => url('').'/issues/show/'.$issue->id,
        //     'img_url' => env('APP_URL')."/Images/jannat/jannati.jpg"
        // );
        // foreach($users as $user)
        // {
        //     Mail::to($user->email)->send(new sendingEmail($data));
        // }
      

        


        // $notification = Notification::create([
        //     'message' => 'A new issue has been created by '.auth()->user()->name.' from '.auth()->user()->center->name,
        //     'subscriber' => 'all',
        //     'url' => url('').'/issues/show/'.$issue->id
        // ]);

        return redirect()->route('issues.biddableIssues')->withMessage('Successfully uploaded');

    }

    public function generateIssueCode($issue, $center_id = null)
    {
        $date = $issue->created_at->format('d-m-Y');
        $date = str_replace("-","_", $date);
        $alarm = $issue->alarm;
        $centerLocation = '';
        if($center_id == null)
        {
            $centerLocation = auth()->user()->center->city;
        }else{
            $center = Center::where('id', $center_id)->first();
            $centerLocation = $center->city;            
        }
        
        $code = $date."_".$centerLocation."_".$alarm;

        return $code;
    }

    public function toShip($user_id)
    {
        // $issues = Issue::where('user_id', $user_id)->where('status', 'assigned')->get();
        $tempIssues = Resolve::where('shipper_id', $user_id)->orderBy('id', 'ASC')->get();
        $issues = array();
        foreach($tempIssues as $tempIssue)
        {
            array_push($issues, $tempIssue->issue);
        }
        // dd($issues);

        foreach($issues as $issue)
        {
            $shipped_date = Resolve::where('issue_id', $issue->id)->first();
            if($shipped_date->shipped_date){
                $issue->shipped_date = $shipped_date->shipped_date;
            }
        }
        return view('issues.items-to-ship', compact('issues'));
    }

    public function forceAssignIssues()
    {
        $issues = Issue::Where('status', 'needForceAssign')->orWhere('status', 'pending')->get();
        return view('issues.force-assign-issues', compact('issues'));
    }
}
