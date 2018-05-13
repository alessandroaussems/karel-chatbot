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
    public function welcome()
    {
        $length = 60*60*24*30;
        if(!isset($_COOKIE['chatsession']))
        {
            $sessionid=uniqid();
            setcookie("chatsession", $sessionid,time() + $length);
            setcookie("visits",1,time() + $length);

            $sessionmessages[0]=["Hallo ik ben Karel! Stel je vragen maar!","B"];

            $session = Session::create([
                'id' => $sessionid,
                'messages' => json_encode($sessionmessages),
                'lastactive' => date('Y-m-d')
            ]);

            return view("chat")->with("messages",[])->with("isconnected",false);
        }
        else
        {
            if(isset($_COOKIE["visits"]))
            {
                setcookie("visits",$_COOKIE["visits"]+=1,time() + $length);
            }
            else
            {
                setcookie("visits",1,time() + $length);
            }
            if(isset($_COOKIE["chatsession"]))
            {
                setcookie("chatsession", $_COOKIE["chatsession"],time() + $length);
            }
            else
            {
                $sessionid=uniqid();
                setcookie("chatsession", $sessionid,time() + $length);
                setcookie("visits",1,time() + $length);

                $sessionmessages[0]=["Hallo ik ben Karel! Stel je vragen maar!","B"];

                $session = Session::create([
                    'id' => $sessionid,
                    'messages' => json_encode($sessionmessages),
                    'lastactive' => date('Y-m-d')
                ]);

                return view("chat")->with("messages",[])->with("isconnected",false);
            }

            $session=Session::find($_COOKIE["chatsession"]);
            $session->lastactive=date("Y-m-d");
            $session->save();

            $session=Session::where('id', $_COOKIE["chatsession"])->first();
            $isconnected = (!is_null($session->login) && !is_null($session->password));

            return view("chat")->with("messages",json_decode($session->messages))->with("isconnected",$isconnected);
        }
    }
}
