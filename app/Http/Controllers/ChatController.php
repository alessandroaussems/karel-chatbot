<?php

namespace App\Http\Controllers;

use App\Providers\KdGClientProvider;
use App\Services\KdGService;
use App\Session;
use Illuminate\Http\Request;
use App\Sentence;
use App\Message;

class ChatController extends Controller
{
    function handleMessage($message)
    {
        $error="Whoops dat heb ik niet verstaan!";
        //ON ERROR: echo "ERROR";
        //RESPONSE: echo "Your response";
        $message=urldecode($message);//DECODE TO ORIGINAL STRING

        $this->AddToSession($message,"H");
        $search=$this->SearchMessage($message); // FIRST CHECKING LITERALLY
        if($search!="none") // IF SUCCESFULL 100% MATCH
        {
            echo $search; // ECHO 100% MATCH ANSWER
            $this->AddToSession($search,"B");
        }
        else // NO 100% MATCH
        {
            $answer=$this->CheckMessagesSequential($message); //LOOP AND CHECK IF RESEMBLANCE
            if($answer!="none") //SOME RESEMBLANCE FOUND
            {
                echo $answer; //ECHO THE RESEMBLANCE
                $this->AddToSession($answer,"B");
            }
            else
            {
                echo $error; //NO 100% MATCH AND NOT RESEMBLANCE
                $this->AddToSession($error,"B");
            }
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
    function SearchMessage($sentence)
    {
        $sentence=Sentence::where("sentence",$sentence)->first();
        if($sentence)
        {
            $message=Message::where("id",$sentence->message_id)->first();
            if($message)
            {
                return $message->answer;
            }
            else
            {
                return "none";
            }
        }
        else
        {
            return "none";
        }

    }
    function CheckMessagesSequential($sentencetocheck)
    {
        $sentences=Sentence::all();
        foreach ($sentences as $sentence => $value)
        {
            similar_text($value->sentence, $sentencetocheck, $perc);
            if($perc>70)
            {
                $message=Message::where("id",$value->message_id)->first();
                return $message->answer;
            }
        }
        return "none";
    }
    function AddToSession($messagetoadd,$who)
    {
        $toadd=[$messagetoadd,$who];
        $session=Session::select('messages')->where('id', $_COOKIE["chatsession"])->first();
        $messages=json_decode($session->messages);
        array_push($messages,$toadd);
        $session=Session::find($_COOKIE["chatsession"]);
        $session->messages=json_encode($messages);
        $session->save();
    }
    function test()
    {
        $KdGService=new KdGService();
        $KdGService->DoLogin("","");
        echo $KdGService->GetNameOfUser()[0].$KdGService->GetNameOfUser()[1];


    }
}

