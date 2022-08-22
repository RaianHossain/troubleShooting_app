<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Role;
use App\Models\User;
use App\Models\Resolve;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();    
         
        return view('users.index', compact('users'));
    }

    public function profile($user_id)
    {
        $user= User::where('id',$user_id)->firstOrFail();
        //dd($user);
        $resolves = Resolve::where('user_id',$user_id)->get();
        return view('users.profile', compact('user','resolves'));
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

    public function upForMoreStatus($user_id, $status)
    {

        $user = User::where('id', $user_id)->first();
        if($status == 'yes')
        {
            $user->up_for_more = 1;
        }else{
            $user->up_for_more = 0;
        }
        $user->update();
    }
}

