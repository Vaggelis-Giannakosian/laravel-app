<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }
    public function contact()
    {
        return view('contact');
    }


    public function blogPost($id, $welcome = 0)
    {

        $pages = [
            1 => ['title' => ' from page 1'],
            2 => ['title' => ' from page 2'],
        ];

        $welcomes = ['Hello', 'Welcome to '];

        return view('blog-post', [
            'title' => $pages[$id],
            'prefix' => $welcomes[$welcome]
        ]);
    }


}
