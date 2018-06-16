<?php

namespace App\Http\Controllers;

use App\Livechat;
use App\Providers\KdGClientProvider;
use App\Services\KdGService;
use App\Session;
use App\User;
use Illuminate\Http\Request;
use App\Keyword;
use App\Message;
use Illuminate\Support\Facades\Config;
use App\Events\SendToUser;
use Illuminate\Support\Facades\Mail;

class ChatController extends Controller
{
    /**
     * @param $message, @echo string
     */
    function handleMessage($message)
    {
        $error="Whoops dat heb ik niet verstaan! &#x1F62D&#x1F62D&#x1F62D";
        //ON ERROR: echo "ERROR";
        //RESPONSE: echo "Your response";
        $message=urldecode($message);//DECODE TO ORIGINAL STRING

        $this->addToSession($message,"H");
        similar_text($message, "Medewerker stop", $perc);
        if($_COOKIE["listen"]=="true" && $perc > 80)
        {
            setcookie("listen","false",time()+60*60*24*30,"/");
            Livechat::where("session_id",$_COOKIE["chatsession"])->delete();
            event(new SendToUser("newchat","oldchatid",["id"=>$_COOKIE["chatsession"]]));
            event(new SendToUser("newchat","chatcount",["number"=>Livechat::count()]));
            event(new SendToUser($_COOKIE["chatsession"],"usermessage",["message"=>"stop"]));
            $this->addToSession("<p>Hopelijk heeft de KdG-Medewerker je kunnen helpen...Vanaf nu kan je al je vragen weer gewoon aan mij stellen, Karel dé chatbot van KdG!</p>","B");
            return "<p>Hopelijk heeft de KdG-Medewerker je kunnen helpen...Vanaf nu kan je al je vragen weer gewoon aan mij stellen, Karel dé chatbot van KdG!</p>";
        }
        if($_COOKIE["listen"]=="true")
        {
            event(new SendToUser($_COOKIE["chatsession"],"usermessage",["message"=>$message,"id"=>$_COOKIE["chatsession"]]));
            return "live";
        }
        $answer=$this->checkMessages($message);
        if($answer!="none") //SOME RESEMBLANCE FOUND
        {
            if($this->isACode($answer))//CHECK IF IT'S MAYBE A CODE FOR RETRIEVING LIVE DATA
            {
                $codes=$this->getTheCode($answer); //GET THE CODES
                foreach ($codes as $code)
                {
                    $answer=str_replace($code,$this->callKdgService($code,$message),$answer);
                }
                $answer=$this->sanitizeTheCode($answer); //REMOVE START AND END TAG
            }
            $this->addToSession($answer,"B");
            return $answer;
        }
        else
        {
            $this->addToSession($error,"B");
            return $error;
        }
    }
    /**
     * @param $sentencetocheck
     * @return string
     */
    function checkMessages($sentencetocheck)
    {
        $sentencetocheck=strtolower($sentencetocheck);
        $idsofmessages=[];
        if(strpos($sentencetocheck, 'Wie is') !== false || strpos($sentencetocheck, 'wie is') !== false )
        {
            return Message::where("id",Keyword::where("keyword","Wie is")->first()->message_id)->first()->answer;
        }
        $keywords=Keyword::all();
        foreach ($keywords as $keyword => $value)
        {
            if(strpos($sentencetocheck,$value->keyword)!==false)
            {
                array_push($idsofmessages,$value->message_id);
            }
            else
            {
                $wordstocheck=explode(" ",$sentencetocheck);
                foreach ($wordstocheck as $wordtocheck)
                {
                    similar_text($wordtocheck,$value->keyword,$perc);
                    if($perc>80)
                    {
                        array_push($idsofmessages,$value->message_id);
                    }
                }
            }
        }
        if(count($idsofmessages)!=0)
        {
            $numberofoccurencesinarray=array_count_values($idsofmessages);
            arsort($numberofoccurencesinarray);
            $popularid=array_keys($numberofoccurencesinarray)[0];
            return Message::where("id",$popularid)->first()->answer;
        }
        return "none";
    }

    /**
     * @param $messagetoadd
     * @param $who
     */
    function addToSession($messagetoadd, $who)
    {
        $messagetoadd=mb_convert_encoding($messagetoadd, 'UTF-8', 'UTF-8'); //Fix possible errors in encoding
        $toadd=[$messagetoadd,$who];
        $session=Session::find($_COOKIE["chatsession"]);
        $messages=json_decode($session->messages);
        array_push($messages,$toadd);
        $session->messages=json_encode($messages);
        $session->save();
    }
    /**
     * @param $answer
     * @return bool
     */
    function isACode($answer)
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
    function getTheCode($answer)
    {
        $startDelimiter=Config::get("kdg.starttag");
        $endDelimiter=Config::get("kdg.endtag");
        $contents = array();
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($answer, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($answer, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $contents[] = substr($answer, $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }
        return $contents;
    }
    /**
     * @param $answer
     * @return mixed
     */
    function sanitizeTheCode($answer)
    {
        $answer=str_replace(Config::get("kdg.starttag")," ",$answer);
        $answer=str_replace(Config::get("kdg.endtag")," ",$answer);
        return $answer;
    }
    /**
     * @param $code
     * @return string
     */
    function callKdgService($code,$message)
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
                        $html.="<h5><a href='".$melding["url"]."' target='blank'>".$melding["title"]."</a></h5>";
                        $html.="<p>".substr($melding["body"],0,150)."...</p>";
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
                    $lessons=$KdGService->getDayLessons();
                    if(!$lessons)
                    {
                        return "Voor vandaag staat er niets gepland! Je kan gezellig thuis blijven!";
                    }
                    foreach ($lessons as $lesson)
                    {
                        $html.="<h4>".$lesson["title"]."</h4>";
                        $html.="</p>".$lesson["time"]."</p>";
                        $html.="<p>".$lesson["location"]."</p>";
                    }
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
                case "WIEISWIE":
                    $searchterm=str_replace("Wie is","",$message);
                    $searchterm=str_replace("wie is","",$searchterm);
                    $searchterm=trim($searchterm);
                    $searchterm=ucwords($searchterm);
                    $person=$KdGService->searchForWhoIsWho($searchterm);
                    if($person)
                    {
                        $currentuser=implode(" ",$KdGService->getNameOfUser());
                        if($searchterm==$currentuser)
                        {
                            $html.="<p>Weet je na al die jaren nog niet wie je bent?</p>";
                        }
                        $html.="<p>Het beste resultaat dat ik kan vinden voor: ".$searchterm." is:</p><br>";
                        $html.="<img style='max-width: 150px;' src='".$person["image"]."' alt='".$person["name"]."'>";
                        $html.="<h5>".$person["name"]."</h5>";
                        if($searchterm==$currentuser)
                        {
                            $html.="<p>Je kan jezelf mailen op: <a href='mailto:".$person["email"]."'>".$person["email"]."</a>, al zie ik geen reden waarom je jezelf zou willen mailen.</p>";
                        }
                        else
                        {
                            $html.="<p>Je kan ".$person["name"] ." bereiken via email: <a href='mailto:".$person["email"]."'>".$person["email"]."</a>";
                        }
                    }
                    else
                    {
                        $html.="<p>Ik heb helaas niets gevonden met de zoekterm: ".$searchterm.", het spijt me ten zeerste!</p>";
                    }
                    break;
                case "MEDEWERKER":
                    if($_COOKIE["listen"]=="true")
                    {
                        return "<p>Je bent momenteel al aan het wachten op het antwoord van een medewerker. Geduld is een mooie deugd...</p>";
                    }
                    else
                    {
                        setcookie("listen","true",time()+60*60*24*30,"/");
                        $livechat=new Livechat();
                        $livechat->session_id=$_COOKIE["chatsession"];
                        $livechat->save();
                        event(new SendToUser("newchat","newchatid",["id"=>$_COOKIE["chatsession"]]));
                        event(new SendToUser("newchat","chatcount",["number"=>Livechat::count()]));
                        if($this->checkIfAdminOnline())
                        {
                            return "<p>Oke! No hard feelings...Vanaf nu ben je aan het chatten met een medewerken van KdG. Stel je vragen maar! Om de sessie te beeïndigen kan je altijd 'Medewerker stop' ingeven.</p>";
                        }
                        else
                        {
                            return "<p>Oke! No hard feelings...Vanaf nu ben je aan het chatten met een medewerken van KdG. Stel je vragen maar! Om de sessie te beeïndigen kan je altijd 'Medewerker stop' ingeven. Er is momenteel <strong>GEEN</strong> medewerker online. Je kan je vraag alsnog stellen, ik stuur je dan een mailtje als je antwoord hebt!</p>";
                        }
                    }
                    break;
                case "CAMPUS":
                        $campusinfo=$KdGService->getCampusInfo();
                        $html.="<p>Adres:&nbsp;<a target='_blank' title='Navigeren' href='https://www.google.com/maps/dir/?api=1&amp;destination=".rawurlencode(str_replace(' ', '', $campusinfo["address"]))."&amp;travelmode=transit'>".$campusinfo["address"]."</a>&nbsp;<a id='marker' target='_blank' title='Navigeren' href='https://www.google.com/maps/dir/?api=1&amp;destination=".rawurlencode(str_replace(' ', '', $campusinfo["address"]))."&amp;travelmode=transit'>j</a>";
                        $html.="<p>Openingsuren van de campus:</p>";
                        $html.=$campusinfo["openinghours"];
                    break;
                case "LEERKREDIET":
                    $html.="<p>".$KdGService->getStudyCredit()."</p><br><small>Dit is de meest recente raadpleging.</small>";
                    break;
                case "BENODIGDHEDEN":
                    $necessities=$KdGService->getStudyNecessities();
                    foreach ($necessities as $necessity)
                    {
                        $html.="<div>";
                        $html.="<h5>".$necessity["title"]."</h5>";
                        $html.="<p>".nl2br($necessity["details"])."</p>";
                        $html.="<p>Opleidingsonderdeel:&nbsp;".$necessity["lesson"]."</p>";
                        $html.="<p>".$necessity["period"]."</p>";
                        $html.="</div>";
                    }
                    break;
                case "VAKKEN":
                    $subjects=$KdGService->getSubjectsWithECTSLink();
                    foreach ($subjects as $subject)
                    {
                        $html.="<h5>".$subject["title"]."<a href='".$subject["ectslink"]."' target='_blank'>(ECTS)</a></h5>";
                    }
                    break;
                case "VERDIENSTELIJKHEID":
                    $meritinfo=$KdGService->getGradeOfMerit();
                    $html.="<p><strong>".$meritinfo["grade"]."%</strong></p>";
                    $html.="<p>Dit betekent: <strong>".$meritinfo["meaning"]."</strong></p>";
                    break;
                default:
                    $html.="Er is iets fout gegaan! &#x1F62D";
                    break;
            }
            return $html;

        }
        else
        {
            return "<p onclick='showLoginForm(this.event)' style='cursor: pointer'><strong>Log je in bij KdG<span style='font-family: icon; border: 1px solid white; margin-left: 1%; margin-right: 1%; padding: 1%' onclick='showLoginForm(this.event)'> h </span> zodat ik deze informatie te weten kan komen!</strong></p>";
        }
    }
    private function checkIfAdminOnline()
    {
        $onlineusers=[];
        $users=User::where("role","chatter")->orWhere("role","admin")->get();
        foreach ($users as $user)
        {
            date_default_timezone_set("Europe/Brussels");
            $differce=round(abs( strtotime(date("Y-m-d H:i:s")) - strtotime($user->last_active)) / 60,0);
            if($differce<4)
            {
                array_push($onlineusers,$user);
            }
            else
            {
                $admin=new \stdClass();
                $admin->email=$user->email;
                $admin->name=$user->name;
                $admin->sessionid=$_COOKIE["chatsession"];
                Mail::send('mail.newlivechat', ['user' => $admin], function ($m) use ($admin) {

                    $m->to($admin->email)->subject('Nieuw livechat vraag!');
                });
            }
        }
        if(count($onlineusers)!=0)
        {
            return true;
        }

        return false;
    }
}

