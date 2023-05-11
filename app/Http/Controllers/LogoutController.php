<?php

namespace App\Http\Controllers;

class LogoutController extends Controller
{
    public function doLogout()
    {
        auth()->logout();
        return redirect('/login')->with('success', 'You are successfully loggedout');
    }
}
