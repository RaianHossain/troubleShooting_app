<?php

namespace App\Http\Controllers;

use App\Models\IssueResolve;
use Illuminate\Http\Request;

class IssueResolveController extends Controller
{
    public function index()
    {
        $issueResolves = IssueResolve::all();
        foreach($issueResolves as $issueResolve)
        {
            $issueResolve->winner = $issueResolve->winner;
            $issueResolve->bid = $issueResolve->winner->bid;
            $issueResolve->user = $issueResolve->winner->bid->user;
            $issueResolve->issue = $issueResolve->winner->bid->issue;
        }
        return view('issueResolves.index', compact('issueResolves'));
    }
}
