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
        $this->middleware("role:editor,admin")->only('tags');
        $this->middleware("role:chatter,admin")->only('chats');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livechats=Livechat::all();
        return view('admin')->with("livechatscount",Livechat::count())->with("livechats",$livechats)->with("pagetitle", "Admin");;
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
        return view("tags")->with("tags",$tags)->with("starttag",$starttag)->with("endtag",$endtag)->with("pagetitle", "Tags");;
    }
    /**
     * Show the list of available chats.
     *
     * @return $this
     */
    public function chats()
    {
        $livechats=Livechat::all();
        $livechats_pag=Livechat::paginate(9);
        return view("livechats")->with("livechats",$livechats)->with("livechats_pag",$livechats_pag)->with("pagetitle", "Livechats");
    }
}
