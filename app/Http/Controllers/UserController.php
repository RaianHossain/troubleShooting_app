<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();    
         
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $centers = Center::all();
        $roles = Role::all();
        return view('users.create', compact('centers', 'roles'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'password' => "test pass",
            'email' => $data['email'],
            'center_id' => $data['center_id'],
            'role_id' => $data['role_id']
        ]);

        return redirect()->route('users.index')->withMessage('Successfully Created');
    }

    public function delete($user_id)
    {
        $user = User::where('id', $user_id)->first()->delete();
        return redirect()->route('users.index')->withMessage('Successfully deleted');
    }
}

