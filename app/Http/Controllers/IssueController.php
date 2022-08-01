<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;

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
        // dd($issues);
        return view('issues.index', compact('issues'));
    }

    public function create()
    {
        $users = User::all();
        return view('issues.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $center = User::where('id', $data['user_id'])->first()->center->name;
        // dd($center);

        $issue = Issue::create([
            'user_id' => $data['user_id'],
            'alarm' => $data['alarm'],
            'occuring_time' => $data['occuring_time'],
            'problem_history' => $data['problem_history'],
            'description' => $data['description'],
            'steps_taken' => $data['steps_taken'],
            'status' => "pending",
            'center' => $center,
        ]);

        return redirect()->route('issues.index')->withMessage('Successfully Created');
    }

    public function delete($issue_id)
    {
        // dd($issue_id);
        $issue = Issue::where('id', $issue_id)->first()->delete();
        return redirect()->route('issues.index');
    }
}
