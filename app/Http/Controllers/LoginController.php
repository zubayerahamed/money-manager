<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Dislay the login page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Do login
     *
     * @param Request $requset
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($request->only([
            'email', 'password'
        ]))) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return redirect('/login')->with('error', __('login.invalid.credentails'));
    }
}
