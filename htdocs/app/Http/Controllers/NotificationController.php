<?php

namespace App\Http\Controllers;

use App\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $sessionid=openssl_decrypt($request->input("sessionid"),"AES-128-ECB",$_ENV['APP_KEY']);
        $session= Session::where("id",$sessionid)->first();
        if(isset($session))
        {
            return view("notifications")->with('session', $session)->with("id",$request->input("sessionid"))->with("pagetitle", "Notificaties");
        }
        else
        {
            abort(404);
        }
    }
    public function update(Request $request,$id)
    {
        $encrypted_id=$id;
        $id=openssl_decrypt($id,"AES-128-ECB",$_ENV['APP_KEY']);
        $validator = Validator::make($request->all(),[
            'sendmail'  => 'required|max:1',
            'sendsms'   => 'required|max:1'
        ]);
        if($validator->fails())
        {
            return Redirect::to('notifications/?sessionid='.$encrypted_id)
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            $session = Session::find($id)->first();
            $session->sendmail=Input::get('sendmail');
            $session->sendsms=Input::get('sendsms');
            $session->save();
            return Redirect::to('notifications/?sessionid='.$encrypted_id)
                    ->withInput()
                    ->withSuccess('Je voorkeuren zijn geüpdatet');
        }
    }
}
