<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KdGService;

class KdgLoginController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->input("login");
        $password=$request->input("password");
        $KdGService=new KdGService();
        if($KdGService->DoLogin($login,$password))
        {
            echo "OK";
        }
        else
        {
            echo "PANIC";
        }


    }
}
