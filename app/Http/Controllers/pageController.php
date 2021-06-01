<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pageController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function page()
    {
        return view('user.page');
    }
}
