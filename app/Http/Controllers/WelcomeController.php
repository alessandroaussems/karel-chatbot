<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Session;

class WelcomeController extends Controller
{
    public function welcome()
    {
        if(!isset($_COOKIE['chatsession']))
        {
            $sessionid=uniqid();
            setcookie("chatsession", $sessionid);
            setcookie("visits",1);

            $sessionmessages[0]=["Hallo ik ben Karel! Stel je vragen maar!","B"];

            $session = new Session();
            $session->id = $sessionid;
            $session->messages=json_encode($sessionmessages);
            $session->lastactive=date('Y-m-d');
            $session->save();

            return view("chat")->with("messages",[]);
        }
        else
        {
            if(isset($_COOKIE["visits"]))
            {
                setcookie("visits",$_COOKIE["visits"]+=1);
            }

            $session=Session::find($_COOKIE["chatsession"]);
            $session->lastactive=date("Y-m-d");
            $session->save();

            $session=Session::select('messages')->where('id', $_COOKIE["chatsession"])->first();
            $messages=json_decode($session->messages);

            return view("chat")->with("messages",$messages);
        }
    }
}
