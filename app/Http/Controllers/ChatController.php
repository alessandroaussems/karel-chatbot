<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    function handleMessage($message)
    {
        //ON ERROR: echo "ERROR";
        //RESPONSE: echo "Your response";
        $witresponsearray=$this->CallWit($message);
        if(count($witresponsearray["entities"])>0)
        {
            $intentvalue=$witresponsearray["entities"]["intent"][0]["value"]; ///GET INTENT VALUE
        }
        else
        {
            $intentvalue="UNDEFINED";
        }
        if($intentvalue=="toestand")
        {
            echo "Goed! En met jou?";
        }
        else
        {
            echo "ERROR";
        }

    }
    function CallWit($message)
    {
        $message=urlencode($message);
        $witaccestoken=$_ENV['WITACCESSTOKEN'];
        $url="https://api.wit.ai/message?q=".$message;
        $authorization = "Authorization: Bearer ".$witaccestoken;
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($ch),true);
        curl_close($ch);
        return $result;
    }
}

