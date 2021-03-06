<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\Livechat;
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
    /**
     * @return $this
     */
    public function welcome()
    {
        if(!isset($_COOKIE["listen"]))
        {
            setcookie("listen","false",time() + $this->length,"/");
        }
        if(isset($_COOKIE["visits"]))
        {
            setcookie("visits",$_COOKIE["visits"]+=1,time() + $this->length,"/");
        }
        else
        {
            setcookie("visits",1,time() + $this->length,"/");
        }
        if(!isset($_COOKIE['chatsession']))
        {
            $this->startNewSession();
            setcookie("listen","false",time() + $this->length,"/");

            return view("chat")->with("messages",[])->with("isconnected",false);
        }
        else
        {
            $session=Session::find($_COOKIE["chatsession"]);
            if(!isset($session))
            {
                $this->startNewSession();
                setcookie("listen","false",time() + $this->length,"/");

                return view("chat")->with("messages",[])->with("isconnected",false);
            }
            else
            {
                if(Livechat::where("session_id",$_COOKIE["chatsession"])->first()!==null)
                {
                    setcookie("listen","true",time() + $this->length,"/");
                }
                else
                {
                    setcookie("listen","false",time() + $this->length,"/");
                }
                date_default_timezone_set("Europe/Brussels");
                $session->last_active=date("Y-m-d H:i:s");
                $session->save();

                $session=Session::where('id', $_COOKIE["chatsession"])->first();
                $isconnected = (!is_null($session->login) && !is_null($session->password));

                return view("chat")->with("messages",json_decode($session->messages))->with("isconnected",$isconnected);
            }
        }
    }
    /**
     * @param $sessionidfromurl
     * @return  /
     */
    public function loadsession(Request $request)
    {
        $sessionidfromurl=openssl_decrypt($request->input("sessionid"),"AES-128-ECB",$_ENV['APP_KEY']);
        setcookie("chatsession", $sessionidfromurl,time() + $this->length,"/");
        if(Livechat::where("session_id",$sessionidfromurl)->first()!==null)
        {
            setcookie("listen","true",time() + $this->length,"/");
        }
        else
        {
            setcookie("listen","false",time() + $this->length,"/");
        }
        setcookie("visits",2,time() + $this->length,"/");
        return redirect("/");
    }
    /**
     * start new session
     */
    private function startNewSession()
    {
        $sessionid=uniqid();
        setcookie("chatsession", $sessionid,time() + $this->length,"/");
        setcookie("visits", 1,time() + $this->length,"/");

        $sessionmessages[0]=["Hallo ik ben Karel! Stel je vragen maar! Weet je niet wat vragen? Dan kan je altijd 'Help' typen!","B"];

        $session= new Session();
        $session->id=$sessionid;
        $session->messages=json_encode($sessionmessages);
        date_default_timezone_set("Europe/Brussels");
        $session->last_active=date('Y-m-d H:i:s');
        $session->save();
    }
}
