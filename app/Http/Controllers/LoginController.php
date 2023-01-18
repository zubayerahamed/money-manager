<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginPage(){
        return view('login');
    }

    public function doLogin(Request $request){

        $incomingFileds = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt(['email' => $incomingFileds['email'], 'password' => $incomingFileds['password']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Logged in successfully');
        }

        return redirect('/login')->with('error', 'Invalid credential');
    }
}
