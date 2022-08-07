<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function index()
    {
        $centers = Center::latest()->get();    
         
        return view('centers.index', compact('centers'));
    }

    public function create()
    {
       return view('centers.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $center = Center::create([
            'name' => $data['name'],
            'city' => $data['city'],
            'concern_person' => $data['concern_person']
        ]);

        return redirect()->route('centers.index')->withMessage('Successfully Created');
    }

    public function delete($center_id)
    {
        $center = Center::where('id', $center_id)->first()->delete();
        return redirect()->route('centers.index')->withMessage('Successfully deleted');
    }
}
