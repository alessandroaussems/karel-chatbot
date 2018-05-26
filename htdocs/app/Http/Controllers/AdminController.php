<?php

namespace App\Http\Controllers;


use App\Livechat;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

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
        $this->middleware('role:editor,admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin')->with("livechats",Livechat::count());
    }
    /**
     * Show the list of available tags.
     *
     * @return \Illuminate\Http\Response
     */
    public function tags()
    {
        $tags=Tag::all();
        $starttag=Config::get("kdg.starttag");
        $endtag=Config::get("kdg.endtag");
        return view("tags")->with("tags",$tags)->with("starttag",$starttag)->with("endtag",$endtag);
    }
    public function chats()
    {
        $livechats=Livechat::all();
        return view("livechats")->with("livechats",$livechats);
    }
}
