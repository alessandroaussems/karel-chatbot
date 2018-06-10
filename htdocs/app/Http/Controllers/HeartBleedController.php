<?php

namespace App\Http\Controllers;

use App\Session;
use Illuminate\Http\Request;

class HeartBleedController extends Controller
{
    public function handlePulse()
    {
        date_default_timezone_set("Europe/Brussels");
        $session=Session::find($_COOKIE["chatsession"]);
        $session->last_active=date("Y-m-d H:i:s");
        $session->save();
    }
}
