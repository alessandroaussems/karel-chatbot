<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
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
        return view('admin');
    }
    /**
     * Show the list of available tags.
     *
     * @return \Illuminate\Http\Response
     */
    public function tags()
    {
        $tags=Tag::all();
        return view("tags")->with("tags",$tags);
    }
}
