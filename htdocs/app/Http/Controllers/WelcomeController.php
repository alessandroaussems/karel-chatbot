<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Session;

class WelcomeController extends Controller
{
    /**
     * @return $this
     */
    public function welcome()
    {
        if(!isset($_COOKIE['chatsession']))
        {
            $sessionid=uniqid();
            setcookie("chatsession", $sessionid,time() + (60*60*24*30));
            setcookie("visits",1,time() + (60*60*24*30));

            $sessionmessages[0]=["Hallo ik ben Karel! Stel je vragen maar!","B"];

            $session = new Session();
            $session->id = $sessionid;
            $session->messages=json_encode($sessionmessages);
            $session->lastactive=date('Y-m-d');
            $session->save();

            return view("chat")->with("messages",[])->with("isconnected",false);
        }
        else
        {
            if(isset($_COOKIE["visits"]))
            {
                setcookie("visits",$_COOKIE["visits"]+=1,time() + (60*60*24*30));
            }
            if(isset($_COOKIE["chatsession"]))
            {
                setcookie("chatsession", $_COOKIE["chatsession"],time() + (60*60*24*30));
            }

            $session=Session::find($_COOKIE["chatsession"]);
            $session->lastactive=date("Y-m-d");
            $session->save();

            $session=Session::where('id', $_COOKIE["chatsession"])->first();
            if(!is_null($session->login) && !is_null($session->password))
            {
                $isconnected=true;
            }
            else
            {
                $isconnected=false;
            }
            $messages=json_decode($session->messages);

            return view("chat")->with("messages",$messages)->with("isconnected",$isconnected);
        }
    }
}
