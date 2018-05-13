<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KdGService;
use App\Session;
use Illuminate\Support\Facades\Mail;

class KdgLoginController extends Controller
{
    /**
     * @param Request $request @echo bool
     */
    public function login(Request $request)
    {
        $login = $request->input("login");
        $password=$request->input("password");
        $chatsession=$request->input("chatsession");
        $KdGService=new KdGService();
        if($KdGService->DoLogin($login,$password))
        {
            $fullname=$KdGService->GetNameOfUser();
            $forname=$fullname[0];
            $lastname=$fullname[1];

            $session=Session::find($chatsession);
            $session->firstname=$forname;
            $session->lastname=$lastname;
            $session->login=$login;
            $session->password=encrypt($password);
            $session->save();

            $user=new \stdClass();
            $user->email=$login;
            $user->name=$forname;
            Mail::send('mail.thanksintranetconnect', ['user' => $user], function ($m) use ($user) {

                $m->to($user->email)->subject('Intranet gekoppeld!');
            });


            echo true;
        }
        else
        {
            echo false;
        }


    }
}
