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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function admin(){
        preg_match('/\/preview\/(.+?)\//', \request()->getPathInfo(), $result);
        $session_id = $result[1];
        return view('game.admin-preview', compact('session_id'));

    }

}
