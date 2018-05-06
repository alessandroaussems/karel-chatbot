<?php
namespace App\Services;
use GuzzleHttp\Client;
use JonnyW\PhantomJs\Client as PhantomClient;
require_once "simple_html_dom.php";

class KdGService
{
    private $client;
    private $cookieJar;
    function __construct()
    {
        $this->client=new Client();
        $this->cookieJar=new \GuzzleHttp\Cookie\CookieJar();
    }

    /**
     * @return bool indicating if login was successful
     */
    public function DoLogin($USER,$PASS)
    {
        //FILLING IN KDG-INTRANET LOGIN FORM
        $response_login = $this->client->post('https://sts.kdg.be/adfs/ls/?wa=wsignin1.0&wtrealm=https%3a%2f%2fintranet.student.kdg.be&wctx=rm%3d1%26id%3dpassive%26ru%3dhttps%253a%252f%252fintranet.student.kdg.be%252f&wct=2018-03-31T12%3a34%3a45Z&wreply=https%3a%2f%2fintranet.student.kdg.be%2f', [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
                'form_params' => [
                    'UserName' => $USER,
                    'Password' => $PASS,
                ],
            ]
        );

        //GET RESPONSE FROM LOGIN INTO PARSER (CONTAINS XML AUTH)
        $auth_html=str_get_html($response_login->getBody()->getContents());
        //GET ALL THE INPUTFIELDS FROM AUTH RESPONSE
        $hidden_fields=$auth_html->find('input');
        //SETTING VALUES INTO VARIABLES
        $wa=$hidden_fields[0]->value;
        $wresult=htmlspecialchars_decode($hidden_fields[1]->value); //DECODING XML
        $wctx=html_entity_decode($hidden_fields[2]->value); //DECODING URL

        //ACTUALL AUTHENTICATION WITH INTRANET WITH AUTH-XML
        $response_intranet = $this->client->post('https://intranet.student.kdg.be:443/', [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
                'form_params' => [
                    'wa' => $wa,
                    'wresult' => $wresult,
                    'wctx' => $wctx,
                ],
            ]
        );
        //THE INTRANET!!!!
        $intranet_html=str_get_html($response_intranet->getBody()->getContents());
        //LOGIN FAILED BECAUSE LOGIN PAGE IS SHOWN
        if($intranet_html->find("h1",0)->plaintext==='                                Welkom op het studentenportaal                         ')
        {
            return FALSE;
        }
        //LOGIN SUCCEEDED BECAUSE WE FIND A TITLE THAT IS BEHIND A LOGIN
        if($intranet_html->find("h1",0)->plaintext==='                  Mijn lessenrooster               ')
        {
            return TRUE;
        }
    }

    /**
     * @return array of notifications
     */
    public function GetNotifications()
    {
        $NOTIFICATIONS=[];
        //BROWSING TO NOTIFICATIONS URL
        $response_notifications = $this->client->get('https://intranet.student.kdg.be/mededelingen', [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );
        //GETTING NOTIFIACTIONS PAGE HTML
        $notifications_html=str_get_html($response_notifications->getBody()->getContents());
        $notifications=$notifications_html->find("div.modAnnouncement");
        //ADDING ALL NOTIFICATIONS TO OUR ARRAY
        foreach($notifications as $notification)
        {
            $NOTIFICATION=[];
            array_push($NOTIFICATION,$notification->find("a",0)->plaintext);
            array_push($NOTIFICATION,$notification->find("div.textblock",0)->plaintext);

            array_push($NOTIFICATIONS,$NOTIFICATION);
        }
        return $NOTIFICATIONS;

    }

    /**
     * @return array @[0]=>firstname @[1]=>lastname
     */
    public function GetNameOfUser()
    {
        //BROWSING TO NAME URL
        $response_name = $this->client->get('https://intranet.student.kdg.be/', [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );
        //GETTING NAME PAGE HTML
        $name_html=str_get_html($response_name->getBody()->getContents());
        //GETTING NAME ELEMENTS TEXT
        $forname=$name_html->find("span.firstname",0)->plaintext;
        $lastname=$name_html->find("span.lastname",0)->plaintext;
        //RETURNING FULL NAME
        $name=[trim($forname),trim($lastname)];
        return $name;
    }
    public function GetDayMenu()
    {
        //BROWSING TO MENU URL
        $response_menu = $this->client->get('https://intranet.student.kdg.be/', [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );
        //GETTING MENU PAGE HTML
        $menu_html=str_get_html($response_menu->getBody()->getContents());
        //GETTING MENU ELEMENT TEXT
        $menu=$menu_html->find("span#pagemain_0_homefooter_0_MyStudyfieldRepeater_MenuText_0",0);
        //RETURNING MENU
        return $menu;
    }
    public function GetDayLessons()
    {
        $this->DoLogin("alessandro.aussems@student.kdg.be","KdGVU5rn");
        //BROWSE TO ROOSTER URL
        $response_lessons = $this->client->get("https://intranet.student.kdg.be/kalender", [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );
        $lessons_html=str_get_html($response_lessons->getBody()->getContents());
        $lessons_html=$this->LinkFixer($lessons_html,"https://mijnrooster.kdg.be/");
        //$this->ProcessLessonHTML($lessons_html);

        $phantom=PhantomClient::getInstance();
        $phantom->getEngine()->setPath("../vendor/bin/phantomjs");
        $phantom_request=$phantom->getMessageFactory()->createRequest('https://intranet.student.kdg.be/kalender', 'GET');
        $phantom_response=$phantom->getMessageFactory()->createResponse();

        $phantom->send($phantom_request,$phantom_response);
        if($phantom_response->getStatus()===200)
        {
            dump($phantom_response->getContent());
        }
        die;
    }
    private function LinkFixer($html,$prefixurltoadd)
    {
        //LOADING ALL LINK TAGS AND ADDING OUR PREFIX TO THE HREF
        $linktags=$html->find("link");
        foreach ($linktags as $linktag)
        {
            $linktag->href=$prefixurltoadd.$linktag->href;
        }
        //LOADING ALL OUR SCRIPT TAGS AND ADDING OUR PREFIX TO THE SRC
        $scriptags=$html->find("script");
        foreach ($scriptags as $scriptag)
        {
            $scriptag->src=$prefixurltoadd.$scriptag->src;
        }
        return $html;
    }
    private function ProcessLessonHTML($html)
    {

        //GETTING IFRAME
        echo $html;
        die;
    }
}