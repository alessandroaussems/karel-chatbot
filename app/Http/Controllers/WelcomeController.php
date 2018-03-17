<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        if(!isset($_COOKIE['chatsession']))
        {
            $sessionid=uniqid();
            setcookie("chatsession", $sessionid);
            setcookie("visits",1);
            return view("chat");
        }
        else
        {
            if(isset($_COOKIE["visits"]))
            {
                setcookie("visits",$_COOKIE["visits"]+=1);
            }
            return view("chat");
        }
    }
}
