<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('user.home');
    }

    public function search(Request $request)
    {
        return view('user.search');
    }

    public function postDetail(Request $request)
    {
        return view('user.single-post');
    }

    public function CreatePost(Request $request){
        return view('user.post');

    }

   
}
