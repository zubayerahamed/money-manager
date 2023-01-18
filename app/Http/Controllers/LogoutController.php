<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function doLogout(){
        auth()->logout();
        return redirect('/login')->with('success', 'You are successfully loggedout');
    }
}
