<?php

namespace App\Http\Controllers;

use App\Providers\KdGClientProvider;
use App\Services\KdGService;
use App\Session;
use Illuminate\Http\Request;
use App\Sentence;
use App\Message;
use Illuminate\Support\Facades\Config;
class ChatController extends Controller
{
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
                $search=str_replace($code,$this->callKdgService($code),$search);
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
                    $answer=str_replace($code,$this->callKdgService($code),$answer);
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
        if(strpos($answer,Config::get("kdg.starttag"))!==false && strpos($answer,Config::get("kdg.endtag"))!==false)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $answer
     * @return mixed|string
     */
    function GetTheCode($answer)
    {
        $string = ' ' . html_entity_decode(strip_tags($answer));
        $ini = strpos($string, Config::get("kdg.starttag"));
        if ($ini == 0) return '';
        $ini += strlen(Config::get("kdg.starttag"));
        $len = strpos($string, Config::get("kdg.endtag"), $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * @param $answer
     * @return mixed
     */
    function SanitizeTheCode($answer)
    {
        $answer=str_replace(Config::get("kdg.starttag")," ",$answer);
        $answer=str_replace(Config::get("kdg.endtag")," ",$answer);
        return $answer;
    }

    /**
     * @param $code
     * @return string
     */
    function callKdgService($code)
    {
        $session=Session::find($_COOKIE["chatsession"]);
        $user=$session->login;
        $password=$session->password;
        if(!is_null($user) && !is_null($password))
        {
            $KdGService=new KdGService();
            $KdGService->doLogin($user,openssl_decrypt($password,"AES-128-ECB",$_ENV['APP_KEY']));
            $html="";
            switch ($code)
            {
                case "MELDINGEN":
                    $html.="<ul>";
                    $meldingen=$KdGService->getNotifications();
                    foreach ($meldingen as $melding)
                    {
                        $html.="<li>";
                        $html.="<h5>".$melding[0]."</h5>";
                        $html.="<p>".substr($melding[1],0,150)."...</p>";
                        $html.="</li>";
                    }
                    $html.="</ul>";
                    break;
                case "DAGMENU":
                    $html.=$KdGService->getDayMenu();
                    break;
                case "NAAM":
                    $html.="<p>".$session->firstname." ".$session->lastname."</p>";
                    break;
                case "LESSEN":
                    $html.="<p>Deze functie is nog in ontwikkeling...</p>";
                    break;
                case "AFWEZIGEN":
                    $html.="<ul style='list-style-type: none; padding: 0'>";
                    $abscents=$KdGService->getAbscents();
                    foreach ($abscents as $abscent)
                    {
                        $html.=html_entity_decode($abscent);
                    }
                    $html.="</ul>";
                    break;
                case "PRINTPRIJZEN":
                    $html.=$KdGService->getPrintPrices();
                    break;
                case "PUNTEN":
                    $KdGService->eStudentserviceAuthentication();
                    $points=$KdGService->getPoints();
                    $html.="<table border='1' style='width: 80%; margin: 0 auto'>";
                    foreach ($points as $lecture => $point)
                    {
                        $html.="<tr><td>".$lecture."</td><td>".$point."</td></tr>";
                    }
                    $html.="</table>";
                    break;
                case "PRIKBORD":
                    $html.="<ul style='padding: 0'>";
                    $bulletinitems=$KdGService->getBulletinboard();
                    foreach ($bulletinitems as $bulletinitem)
                    {
                        $html.="<li>";
                        $html.="<h5>".strtoupper($bulletinitem["sort"]).": ".$bulletinitem["title"]."</h5>";
                        $html.="<p>".html_entity_decode($bulletinitem["body"])."</p>";
                        $html.="</li>";
                    }
                    $html.="</ul>";
                    break;
                default:
                    $html.="Er is iets fout gegaan! &#x1F62D";
                    break;
            }
            return $html;

        }
        else
        {
            return "<p onclick='showLoginForm(this.event)' style='cursor: pointer'><strong>Log je in bij KdG zodat ik deze informatie te weten kan komen!</strong></p>";
        }
    }
}

