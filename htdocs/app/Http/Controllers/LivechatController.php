<?php

namespace App\Http\Controllers;

use App\Session;
use App\Events\SendToUser;

class LivechatController extends Controller
{
    public function livechat($sessionid)
    {
        $session=Session::find($_COOKIE["chatsession"]);
        return view("livechat")->with("messages",json_decode($session->messages));
    }
    public function handleMessage($message)
    {
        $message=urldecode($message);//DECODE TO ORIGINAL STRING
        $this->AddToSession($message,"B");
        event(new SendToUser($_COOKIE["chatsession"],"chatmessage",["message"=>$message]));
    }
    /**
     * @param $messagetoadd
     * @param $who
     */
    function AddToSession($messagetoadd, $who)
    {
        $toadd=[$messagetoadd,$who];
        $session=Session::select('messages')->where('id', $_COOKIE["chatsession"])->first();
        $messages=json_decode($session->messages);
        array_push($messages,$toadd);
        $session=Session::find($_COOKIE["chatsession"]);
        $session->messages=json_encode($messages);
        $session->save();
    }
}
