<?php

namespace App\Http\Controllers;

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
    public function tags()
    {
        $startag="[intranet]";
        $endtag="[/intranet]";
        $tags=
        [
            "NAAM",
            "MELDINGEN",
            "DAGMENU"
        ];
        $explanations=
        [
            "Geeft de naam van huidige gebruiker.",
            "Geeft de intranetmeldingen van de huidige gebruiker",
            "Geeft het dagmenu voor de campus van de huidige gebruiker"
        ];
        foreach ($tags as &$tag)
        {
            $tag=$startag.$tag.$endtag;
        }
        return view("tags")->with("tags",$tags)->with("explanations",$explanations);
    }
}
