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
        $this->AddToSession($message,"B",$sessionid);
        event(new SendToUser($sessionid,"chatmessage",["message"=>$message]));
    }
    /**
     * @param $messagetoadd
     * @param $who
     */
    private function AddToSession($messagetoadd, $who,$sessionid)
    {
        $toadd=[$messagetoadd,$who];
        $session=Session::select('messages')->where('id', $sessionid)->first();
        $messages=json_decode($session->messages);
        $session->messages=json_encode(array_push($messages,$toadd));
        $session->save();
    }
}
