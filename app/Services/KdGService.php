<?php
namespace App\Services;
use GuzzleHttp\Client;
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
        $name=[$forname,$lastname];
        return $name;
    }
}