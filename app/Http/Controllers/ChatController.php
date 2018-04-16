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
    private $pleaselogin;
    private $starttag="[intranet]";
    private $endtag="[/intranet]";
    public function __construct()
    {
        $this->pleaselogin="<strong>Log je in bij KdG zodat ik deze informatie te weten kan komen!</strong>";
    }
    /**
     * @param $message, @echo string
     */
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
            if($this->IsACode($search))//CHECK IF IT'S MAYBE A CODE FOR RETRIEVING LIVE DATA
            {
                $code=$this->GetTheCode($search); //GET THE CODE
                $search=str_replace($code,$this->$code(),$search); //CALL FUNCTION WITH NAME OF THE CODE
                $search=$this->SanitizeTheCode($search); //REMOVE START AND END TAG
                echo $search;
            }
            else
            {
                echo $search; //ECHO THE RESEMBLANCE
            }
            $this->AddToSession($search,"B");
        }
        else // NO 100% MATCH
        {
            $answer=$this->CheckMessagesSequential($message); //LOOP AND CHECK IF RESEMBLANCE
            if($answer!="none") //SOME RESEMBLANCE FOUND
            {
                if($this->IsACode($answer))//CHECK IF IT'S MAYBE A CODE FOR RETRIEVING LIVE DATA
                {
                    $code=$this->GetTheCode($answer);//GET THE CODE
                    $answer=str_replace($code,$this->$code(),$answer);//CALL FUNCTION WITH NAME OF THE CODE
                    $answer=$this->SanitizeTheCode($answer); //REMOVE START AND END TAG
                    echo $answer;
                }
                else
                {
                    echo $answer; //ECHO THE RESEMBLANCE
                }
                $this->AddToSession($answer,"B");
            }
            else
            {
                echo $error; //NO 100% MATCH AND NOT RESEMBLANCE
                $this->AddToSession($error,"B");
            }
        }


    }
    /*
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
    }*/
    /**
     * @param $sentence
     * @return string
     */
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

    /**
     * @param $sentencetocheck
     * @return string
     */
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

    /**
     * @param $messagetoadd
     * @param $who
     */
    function AddToSession($messagetoadd, $who)
    {
        $toadd=[$messagetoadd,$who];
        $session=Session::select('messages')->where('id', $_COOKIE["chatsession"])->first();
        $messages=json_decode($session->messages);
        array_push($messages,$toadd);
        $session=Session::find($_COOKIE["chatsession"]);
        $session->messages=json_encode($messages);
        $session->save();
    }

    /**
     * @param $answer
     * @return bool
     */
    function IsACode($answer)
    {
        $answer=html_entity_decode(strip_tags($answer));
        if(strpos($answer,$this->starttag)!==false && strpos($answer,$this->endtag)!==false)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * @param $answer
     * @return mixed|string
     */
    function GetTheCode($answer)
    {
        $string = ' ' . html_entity_decode(strip_tags($answer));
        $ini = strpos($string, $this->starttag);
        if ($ini == 0) return '';
        $ini += strlen($this->starttag);
        $len = strpos($string, $this->endtag, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    function SanitizeTheCode($answer)
    {
        $answer=str_replace($this->starttag," ",$answer);
        $answer=str_replace($this->endtag," ",$answer);
        return $answer;
    }
    /**
     * @return string
     */
    function MELDINGEN()
    {
        $MELDINGENHTML="<ul>";
        $session=Session::find($_COOKIE["chatsession"]);
        $user=$session->login;
        $password=$session->password;
        if(!is_null($user) && !is_null($password))
        {
            $KdGService=new KdGService();
            $KdGService->DoLogin($user,decrypt($password));
            $meldingen=$KdGService->GetNotifications();
            foreach ($meldingen as $melding)
            {
                $MELDINGENHTML.="<li>";
                $MELDINGENHTML.="<h5>".$melding[0]."</h5>";
                $MELDINGENHTML.="<p>".substr($melding[1],0,150)."...</p>";
                $MELDINGENHTML.="</li>";
            }
            $MELDINGENHTML.="</ul>";
            return $MELDINGENHTML;
        }
        else
        {
            return $this->pleaselogin;
        }
    }

    /**
     * @return string
     */
    function NAAM()
    {
        $session=Session::find($_COOKIE["chatsession"]);
        $user=$session->login;
        $password=$session->password;
        if(!is_null($user) && !is_null($password))
        {
            $KdGService=new KdGService();
            $KdGService->DoLogin($user,decrypt($password));
            $fullname=$KdGService->GetNameOfUser();
            return "<p>".$fullname[0]." ".$fullname[1]."</p>";
        }
        else
        {
            $this->pleaselogin;
        }
    }
}

