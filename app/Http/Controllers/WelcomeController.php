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

            $sessionmessages[0]="Hallo ik ben Karel! Stel je vragen maar!";
            $sessionmessages[1]="Hallo ik ben Karel! Stel je vragen maar!";
            $sessionmessages[2]="Hallo ik ben Karel! Stel je vragen maar!";
            $sessionmessages[3]="Hallo ik ben Karel! Stel je vragen maar!";

            $session = new Session();
            $session->id = $sessionid;
            $session->messages=json_encode($sessionmessages);
            $session->lastactive=date('Y-m-d');
            $session->save();

            return view("chat");
        }
        else
        {
            if(isset($_COOKIE["visits"]))
            {
                setcookie("visits",$_COOKIE["visits"]+=1);
            }
            $session=Session::select('messages')->where('id', $_COOKIE["chatsession"])->first();
            var_dump(json_decode($session->messages));

            return view("chat");
        }
    }
}
