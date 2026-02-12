<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        $users=User::all();
        return view('backend.users.users.users', compact('users'));
    }

    public function edit($id){
        $user=User::findOrFail($id);
        return view('backend.users.users.edit_user', compact('user'));
    }

    public function update(Request $request, $id){
        $user=User::findOrFail($id);
        $request->validate([
            'user_name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'status'=>'required|in:active,inactive,suspended',
        ]);
        $user->name=$request->user_name;
        $user->email=$request->email;
        $user->role_id=$request->role;
        $user->status=$request->status;
        $user->save();
        return redirect()->route('users.users')->with('update_message','User updated successfully.');
    }

    public function destroy($id){
        $user=User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.users')->with('delete_message','User deleted successfully.');
    }
}
