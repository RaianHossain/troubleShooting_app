<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->get();        
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $role = Role::create([
            'name' => $data['name']
        ]);

        return redirect()->route('roles.index')->withMessage('Successfully Created');
    }

    public function delete($role_id)
    {
        $role = Role::where('id', $role_id)->first()->delete();
        return redirect()->route('roles.index')->withMessage('Successfully deleted');
    }
}

