<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('intendedRoute'))
        {
          $my_route = session('intendedRoute');
          session()->forget('intendedRoute');

          return redirect()->route($my_route);
        }
        
        return view('home');
    }
}
