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
        $phantom=PhantomClient::getInstance();
        $phantom->getEngine()->setPath("../vendor/bin/phantomjs");
        $phantom->isLazy();
        $phantom_request=$phantom->getMessageFactory()->createRequest();
        $phantom_request->setMethod("GET");
        $phantom_request->setUrl("https://mijnrooster.kdg.be/m/?requireLogin=true");

        $phantom_response=$phantom->getMessageFactory()->createResponse();

        $phantom->send($phantom_request,$phantom_response);

        $actionurl=str_get_html($phantom_response->getContent())->find("form",0)->action;
        dump($actionurl);

        echo str_get_html($phantom_response->getContent());
        $phantom_requestL=$phantom->getMessageFactory()->createRequest();
        $phantom_responseL=$phantom->getMessageFactory()->createResponse();


        $phantom_requestL->setMethod("POST");
        $phantom_requestL->setUrl("https://sts.kdg.be".$actionurl);
        $data = array(
            'UserName' => "alessandro.aussems@student.kdg.be",
            'Password' => "KdGVU5rn",
        );
        $phantom_requestL->setRequestData($data);

        $phantom->send($phantom_requestL,$phantom_responseL);

        echo $phantom_responseL->getContent();
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
    public function GetAbscents()
    {
        //BROWSING TO INTRANET URL
        $response_intranet = $this->client->get('https://intranet.student.kdg.be/', [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );
        //GETTING ABSCENTS LINK
        $linktoabscents=str_get_html($response_intranet->getBody()->getContents())->find("nav",0)->find("ul",0)->find("li",0)->find("a",0)->href;
        //BROWSING TO ABSCENTS URL
        $response_abscents = $this->client->get($linktoabscents, [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );

        //ABSCENTS HTML
        $abscenturl=str_get_html($response_abscents->getBody()->getContents())->find("iframe",1)->src;
        $response_abscents_frame = $this->client->get(htmlspecialchars_decode($abscenturl), [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );
        $abscentshtml=str_get_html($response_abscents_frame->getBody()->getContents());
        $abscentshtml=$abscentshtml->find("li");
        $ABSCENTS="<ul style='list-style-type: none; padding: 0'>";
        foreach ($abscentshtml as $abscent)
        {
            $ABSCENTS.=html_entity_decode($abscent);
        }
        $ABSCENTS.="</ul>";
        return $ABSCENTS;
    }
    public function GetPrintPrices()
    {
        //BROWSING TO PRINT.KDG
        $response_printkdg = $this->client->get('http://print.kdg.be/', [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );
        //GETTING NOTIFIACTIONS PAGE HTML
        $printkdghtml=str_get_html($response_printkdg->getBody()->getContents());
        $pricestable=$printkdghtml->find("table",0);
        return $pricestable;
    }
}