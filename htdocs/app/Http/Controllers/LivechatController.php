<?php

namespace App\Http\Controllers;

use App\Session;
use App\Events\SendToUser;
use Illuminate\Support\Facades\Mail;

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
        $session=Session::find($sessionid);
        $message=urldecode($message);//DECODE TO ORIGINAL STRING
        $this->addToSession($message,"B",$sessionid);
        event(new SendToUser($sessionid,"chatmessage",["message"=>$message]));
        if($this->userIsOffline($sessionid))
        {
            $user=new \stdClass();
            $user->email=$session->login;
            $user->name=$session->firstname;
            Mail::send('mail.newchatmessage', ['user' => $user], function ($m) use ($user) {

                $m->to($user->email)->subject('Nieuw bericht!');
            });
        }
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
    private function userIsOffline($session)
    {
        date_default_timezone_set("Europe/Brussels");
        $session=Session::find($session);
        $differce=round(abs( strtotime(date("Y-m-d H:i:s")) - strtotime($session->last_active)) / 60,0);
        if($differce>4)
        {
            return true;
        }
        return false;
    }
}
