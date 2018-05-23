<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Session;

class WelcomeController extends Controller
{
    /**
     * Show the chatbox.
     *
     * @return \Illuminate\Http\Response
     */
    private $length = 60*60*24*30;
    public function welcome()
    {
        if(!isset($_COOKIE["listen"]))
        {
            setcookie("listen","false",time() + $this->length);
        }
        if(isset($_COOKIE["visits"]))
        {
            setcookie("visits",$_COOKIE["visits"]+=1,time() + $this->length);
        }
        else
        {
            setcookie("visits",1,time() + $this->length);
        }
        if(!isset($_COOKIE['chatsession']))
        {
            $this->startNewSession();
            return view("chat")->with("messages",[])->with("isconnected",false);
        }
        else
        {
            $session=Session::find($_COOKIE["chatsession"]);
            if(!isset($session))
            {
                $this->startNewSession();
                return view("chat")->with("messages",[])->with("isconnected",false);
            }
            else
            {
                $session->last_active=date("Y-m-d");
                $session->save();

                $session=Session::where('id', $_COOKIE["chatsession"])->first();
                $isconnected = (!is_null($session->login) && !is_null($session->password));

                return view("chat")->with("messages",json_decode($session->messages))->with("isconnected",$isconnected);
            }
        }
    }
    private function startNewSession()
    {
        $sessionid=uniqid();
        setcookie("chatsession", $sessionid,time() + $this->length);
        setcookie("visits",1,time() + $this->length);

        $sessionmessages[0]=["Hallo ik ben Karel! Stel je vragen maar!","B"];

        $session= new Session();
        $session->id=$sessionid;
        $session->messages=json_encode($sessionmessages);
        $session->last_active=date('Y-m-d');
        $session->save();
    }
}
