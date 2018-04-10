<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KdGService;
use App\Session;

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
            $session->forname=$forname;
            $session->lastname=$lastname;
            $session->login=$login;
            $session->password=encrypt($password);
            $session->save();


            echo TRUE;
        }
        else
        {
            echo FALSE;
        }


    }
}
