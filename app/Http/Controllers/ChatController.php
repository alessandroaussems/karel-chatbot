<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    function handleMessage($message)
    {
        echo $message;
    }
}
