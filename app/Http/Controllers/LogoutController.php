<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class LogoutController extends Controller
{

    /**
     * Do Logout
     * 
     * @return Renderable
     */
    public function doLogout()
    {
        auth()->logout();
        return redirect('/login');
    }
}
