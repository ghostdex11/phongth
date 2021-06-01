<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pageController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function gethome()
    {
        return view('user.page');
    }
}
