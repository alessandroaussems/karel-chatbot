<?php

namespace App\Http\Controllers;

use App\Session;
use App\Events\SendToUser;

class LivechatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:chatter,admin');
    }
    /**
     * @param $sessionid
     * @return $this
     */
    public function livechat($sessionid)
    {
        $session=Session::find($sessionid);
        if(!isset($session))
        {
            abort(404);
        }
        return view("livechat")->with("messages",json_decode($session->messages));
    }
    /**
     * @param $message
     */
    public function handleMessage($message,$sessionid)
    {
        $message=urldecode($message);//DECODE TO ORIGINAL STRING
        $this->addToSession($message,"B",$sessionid);
        event(new SendToUser($sessionid,"chatmessage",["message"=>$message]));
    }
    /**
     * @param $messagetoadd
     * @param $who
     */
    private function addToSession($messagetoadd, $who, $sessionid)
    {
        $messagetoadd=mb_convert_encoding($messagetoadd, 'UTF-8', 'UTF-8'); //Fix possible errors in encoding
        $toadd=[$messagetoadd,$who];
        $session=Session::find($sessionid);
        $messages=json_decode($session->messages);
        array_push($messages,$toadd);
        $session->messages=json_encode($messages);
        $session->save();
    }
}
