<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $groups = Group::paginate(6);
        return view('home')->with('groups', $groups);
    }
}
