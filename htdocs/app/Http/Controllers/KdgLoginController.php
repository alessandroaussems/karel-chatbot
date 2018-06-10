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
        if($KdGService->doLogin($login,$password))
        {
            $fullname=$KdGService->getNameOfUser();

            $session=Session::find($chatsession);
            $session->firstname=$fullname["firstname"];
            $session->lastname=$fullname["lastname"];
            $session->login=$login;
            $session->password=openssl_encrypt($password,"AES-128-ECB",$_ENV['APP_KEY']);
            $session->save();

            $user=new \stdClass();
            $user->email=$login;
            $user->name=$fullname["firstname"];;
            Mail::send('mail.thanksintranetconnect', ['user' => $user], function ($m) use ($user) {

                $m->to($user->email)->subject('Intranet gekoppeld!');
            });


            echo json_encode(true);
        }
        else
        {
            echo json_encode(false);
        }


    }
}
