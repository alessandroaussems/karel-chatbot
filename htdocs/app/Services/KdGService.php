<?php
namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Sunra\PhpSimple\HtmlDomParser;

class KdGService
{
    private $client;
    private $cookieJar;
    public function __construct()
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
        try
        {
            $response_login = $this->client->post(Config::get("kdg.sts").'/adfs/ls/?wa=wsignin1.0&wtrealm=https%3a%2f%2fintranet.student.kdg.be&wctx=rm%3d1%26id%3dpassive%26ru%3dhttps%253a%252f%252fintranet.student.kdg.be%252f&wct=2018-03-31T12%3a34%3a45Z&wreply=https%3a%2f%2fintranet.student.kdg.be%2f', [
                    'allow_redirects' => true,
                    'cookies' => $this->cookieJar,
                    'form_params' => [
                        'UserName' => $USER,
                        'Password' => $PASS,
                    ],
                ]
            );
        }
        catch (\Exception $e)
        {
            //die($e->getMessage());
            die ("Er ging iets mis! &#x1F62D");
        }
        //GET RESPONSE FROM LOGIN INTO PARSER (CONTAINS XML AUTH)
        $auth_html=HtmlDomParser::str_get_html($response_login->getBody()->getContents());
        //GET ALL THE INPUTFIELDS FROM AUTH RESPONSE
        $hidden_fields=$auth_html->find('input');
        //SETTING VALUES INTO VARIABLES
        $wa=$hidden_fields[0]->value;
        $wresult=htmlspecialchars_decode($hidden_fields[1]->value); //DECODING XML
        $wctx=html_entity_decode($hidden_fields[2]->value); //DECODING URL

        //ACTUALL AUTHENTICATION WITH INTRANET WITH AUTH-XML
        try
        {
            $response_intranet = $this->client->post(Config::get("kdg.intranet").':443/', [
                    'allow_redirects' => true,
                    'cookies' => $this->cookieJar,
                    'form_params' => [
                        'wa' => $wa,
                        'wresult' => $wresult,
                        'wctx' => $wctx,
                    ],
                ]
            );
        }
        catch (\Exception $e)
        {
            //die($e->getMessage());
            die ("Er ging iets mis! &#x1F62D");
        }
        //THE INTRANET!!!!
        $intranet_html=HtmlDomParser::str_get_html($response_intranet->getBody()->getContents());
        //LOGIN FAILED BECAUSE LOGIN PAGE IS SHOWN
        if($intranet_html->find("h1",0)->plaintext==='                                Welkom op het studentenportaal                         ')
        {
            return false;
        }
        //LOGIN SUCCEEDED BECAUSE WE FIND A TITLE THAT IS BEHIND A LOGIN
        if($intranet_html->find("h1",0)->plaintext==='                  Mijn lessenrooster               ')
        {
            return true;
        }
    }
    public function EStudentServiceAuthentication($USER,$PASSWORD)
    {
        //FILLING IN E-STUDENTSERVICE LOGIN FORM
        $response_estudentservice = $this->client->post(Config::get("kdg.estudentservice").'/Main.aspx', [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
                'form_params' => [
                    'UserName' => $USER,
                    'Password' => $PASSWORD,
                ],
            ]
        );
        //GET RESPONSE FROM LOGIN INTO PARSER (CONTAINS XML AUTH)
        $auth_html=HtmlDomParser::str_get_html($response_estudentservice->getBody()->getContents());
        //GET ALL THE INPUTFIELDS FROM AUTH RESPONSE
        $hidden_fields=$auth_html->find('input');
        //SETTING VALUES INTO VARIABLES
        $wa=$hidden_fields[0]->value;
        $wresult=htmlspecialchars_decode($hidden_fields[1]->value); //DECODING XML
        $wctx=html_entity_decode($hidden_fields[2]->value); //DECODING URL

        //ACTUALL AUTHENTICATION WITH INTRANET WITH AUTH-XML
        $response_estudentservice = $this->client->post(Config::get("kdg.estudentservice").':443/', [
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
        $estudentservice_html=HtmlDomParser::str_get_html($response_estudentservice->getBody()->getContents());
        echo $estudentservice_html;
        die;
    }

    /**
     * @return array of notifications
     */
    public function GetNotifications()
    {
        $NOTIFICATIONS=[];
        //BROWSING TO NOTIFICATIONS URL
        try
        {
            $response_notifications = $this->client->get(Config::get("kdg.intranet").'/mededelingen', [
                    'allow_redirects' => true,
                    'cookies' => $this->cookieJar,
                ]
            );
        }
        catch (\Exception $e)
        {
            //die($e->getMessage());
            die ("Er ging iets mis! &#x1F62D");
        }
        //GETTING NOTIFIACTIONS PAGE HTML
        $notifications_html=HtmlDomParser::str_get_html($response_notifications->getBody()->getContents());
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
     * @return null|\simplehtmldom_1_5\simple_html_dom_node|\simplehtmldom_1_5\simple_html_dom_node[]
     */
    public function GetDayMenu()
    {
        //BROWSING TO MENU URL
        try
        {
            $response_menu = $this->client->get(Config::get("kdg.intranet"), [
                    'allow_redirects' => true,
                    'cookies' => $this->cookieJar,
                ]
            );
        }
        catch (\Exception $e)
        {
            //die($e->getMessage());
            die ("Er ging iets mis! &#x1F62D");
        }
        //GETTING MENU PAGE HTML
        $menu_html=HtmlDomParser::str_get_html($response_menu->getBody()->getContents());
        //GETTING MENU ELEMENT TEXT
        $menu=$menu_html->find("span#pagemain_0_homefooter_0_MyStudyfieldRepeater_MenuText_0",0);
        //RETURNING MENU
        return $menu;
    }

    /**
     * @return null|\simplehtmldom_1_5\simple_html_dom_node|\simplehtmldom_1_5\simple_html_dom_node[]|string
     */
    public function GetAbscents()
    {
        //BROWSING TO INTRANET URL
        try
        {
            $response_intranet = $this->client->get(Config::get("kdg.intranet"), [
                    'allow_redirects' => true,
                    'cookies' => $this->cookieJar,
                ]
            );
        }
        catch (\Exception $e)
        {
            //die($e->getMessage());
            die ("Er ging iets mis! &#x1F62D");
        }
        //GETTING ABSCENTS LINK
        $linktoabscents=HtmlDomParser::str_get_html($response_intranet->getBody()->getContents())->find("nav",0)->find("ul",0)->find("li",0)->find("a",0)->href;
        //BROWSING TO ABSCENTS URL
        $response_abscents = $this->client->get($linktoabscents, [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );

        //ABSCENTS HTML
        $abscenturl=HtmlDomParser::str_get_html($response_abscents->getBody()->getContents())->find("iframe",1)->src;
        $response_abscents_frame = $this->client->get(htmlspecialchars_decode($abscenturl), [
                'allow_redirects' => true,
                'cookies' => $this->cookieJar,
            ]
        );
        $abscentshtml=HtmlDomParser::str_get_html($response_abscents_frame->getBody()->getContents());
        $abscents=$abscentshtml->find("li");
        return $abscents;
        $ABSCENTS="<ul style='list-style-type: none; padding: 0'>";
        foreach ($abscentshtml as $abscent)
        {
            $ABSCENTS.=html_entity_decode($abscent);
        }
        $ABSCENTS.="</ul>";
        return $ABSCENTS;
    }

    /**
     * @return null|\simplehtmldom_1_5\simple_html_dom_node|\simplehtmldom_1_5\simple_html_dom_node[]
     */
    public function GetPrintPrices()
    {
        //BROWSING TO PRINT.KDG
        try
        {
            $response_printkdg = $this->client->get(Config::get("kdg.print"), [
                    'allow_redirects' => true,
                    'cookies' => $this->cookieJar,
                ]
            );
        }
        catch (\Exception $e)
        {
            //die($e->getMessage());
            die ("Er ging iets mis! &#x1F62D");
        }
        //GETTING NOTIFIACTIONS PAGE HTML
        $printkdghtml=HtmlDomParser::str_get_html($response_printkdg->getBody()->getContents());
        $pricestable=$printkdghtml->find("table",0);
        return $pricestable;
    }
}