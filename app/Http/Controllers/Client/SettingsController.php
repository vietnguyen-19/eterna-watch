<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

class SetiingsController extends Controller
{
    public function index() {
        return view('settings', ['user' => Auth::user()]);
    }
  
    public function update(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        if($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}

