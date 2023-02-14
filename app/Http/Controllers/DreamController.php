<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DreamController extends Controller
{
    public function dreams(){
        return view('dreams');
    }

    public function showCreateDreamPage(){

        return view('dream-create');
    }
}
