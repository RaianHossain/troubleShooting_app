<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Engineer;
use Illuminate\Http\Request;

class EngineerController extends Controller
{
    public function index()
    {
        $engineers = Engineer::latest()->get();        
        return view('engineers.index', compact('engineers'));
    }

    public function create()
    {
        $centers = Center::all();
        return view('engineers.create', compact('centers'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $engineer = Engineer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'center_id' => $data['center_id']
        ]);

        return redirect()->route('engineers.index')->withMessage('Successfully Created');
    }

    public function delete($engineer_id)
    {
        $engineer = Engineer::where('id', $engineer_id)->first()->delete();
        return redirect()->route('engineers.index')->withMessage('Successfully deleted');
    }
}
