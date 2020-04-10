<?php

namespace App\Http\Controllers;

use App\BlogPost;
use Illuminate\Http\Request;

class HomeController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth')->except(['contact']);
//        $this->middleware('auth')->only(['home']);
//    }

    public function home()
    {
        return view('home');
    }
    public function contact()
    {
        return view('contact');
    }



}
