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
    public function doLogin($USER, $PASS)
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
    /**
     * @return bool
     */
    public function eStudentserviceAuthentication()
    {
        //FILLING IN E-STUDENTSERVICE LOGIN FORM
        try
        {
            $response_estudentservice = $this->client->post(Config::get("kdg.estudentservice").'/Main.aspx', [
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
        //GET RESPONSE FROM LOGIN INTO PARSER (CONTAINS XML AUTH)
        $auth_html=HtmlDomParser::str_get_html($response_estudentservice->getBody()->getContents());
        //GET ALL THE INPUTFIELDS FROM AUTH RESPONSE
        $hidden_fields=$auth_html->find('input');
        //SETTING VALUES INTO VARIABLES
        $wa=$hidden_fields[0]->value;
        $wresult=htmlspecialchars_decode($hidden_fields[1]->value); //DECODING XML
        $wctx=html_entity_decode($hidden_fields[2]->value); //DECODING URL

        //ACTUALL AUTHENTICATION WITH STUDENTSERVICE WITH AUTH-XML
        try
        {
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
        }
        catch (\Exception $e)
        {
            //die($e->getMessage());
            die ("Er ging iets mis! &#x1F62D");
        }
        //THE SERVICE!!!!
        return true;
    }
    /**
     * @return array @[0]=>firstname @[1]=>lastname
     */
    public function getNameOfUser()
    {
        //BROWSING TO NAME URL
        try
        {
            $response_name = $this->client->get('https://intranet.student.kdg.be/', [
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
        //GETTING NAME PAGE HTML
        $name_html=HtmlDomParser::str_get_html($response_name->getBody()->getContents());
        //GETTING NAME ELEMENTS TEXT
        $forname=$name_html->find("span.firstname",0)->plaintext;
        $lastname=$name_html->find("span.lastname",0)->plaintext;
        //RETURNING FULL NAME
        $name=[trim($forname),trim($lastname)];
        return $name;
    }
    /**
     * @return array of notifications
     */
    public function getNotifications()
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
        return array_slice($NOTIFICATIONS, 0, 3);

    }

    /**
     * @return null|\simplehtmldom_1_5\simple_html_dom_node|\simplehtmldom_1_5\simple_html_dom_node[]
     */
    public function getDayMenu()
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
    public function getAbscents()
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
    public function getPrintPrices()
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

    /**
     * @return array
     */
    public function getPoints()
    {
        //BROWSING TO INTRANET URL
        try
        {
            $response_estudentservice = $this->client->get(Config::get("kdg.estudentservice").'/Main.aspx', [
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
        $estudent_html=HtmlDomParser::str_get_html($response_estudentservice->getBody()->getContents());
        $pointsurl=$estudent_html->find("a.mnu",10)->href;
        try
        {
            $response_points = $this->client->get(Config::get("kdg.estudentservice").'/'.$pointsurl, [
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
        $points_html=HtmlDomParser::str_get_html($response_points->getBody()->getContents())
                    ->find("table.IndivRapRapondTable",0)
                    ->find("tr");
        $points=[];
        foreach ($points_html as $i => $pointsrow)
        {
            if($i!=0)
            {
                if($pointsrow->find("td",0)!="")
                {
                    $points[$pointsrow->find("td",1)->plaintext]=$pointsrow->find("td",5)->plaintext;
                }
            }
        }
        return $points;
    }
    public function getBulletinboard()
    {
        //BROWSING TO Bulletinboard url
        try
        {
            $response_bulletinboard = $this->client->get(Config::get("kdg.intranet").'/studentenleven/prikbord', [
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
        $bulletin=[];
        $bulletinitems=HtmlDomParser::str_get_html($response_bulletinboard->getBody()->getContents())
                       ->find("div.event");
        foreach ($bulletinitems as $bulletinitem)
        {
            $bulletinarticle=[];
            $bulletinarticle["title"]=$bulletinitem->find("article",0)->find("h1",0)->find("span",0)->find("a",0)->plaintext;
            $bulletinarticle["sort"]=trim($bulletinitem->find("article",0)->find("div.category",0)->find("div.value",0)->plaintext);
            $bulletinarticle["body"]=$this->createHtmlLinksFromString(trim($bulletinitem->find("article",0)->find("div.description",0)->plaintext));
            array_push($bulletin,$bulletinarticle);
        }
        return $bulletin;
    }
    private function createHtmlLinksFromString($string)
    {
        $regex="/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        if(preg_match($regex, $string, $url))
        {
            return preg_replace($regex, "<a target='_blank' href='".$url[0]."'>".$url[0]."</a> ", $string);
        }
        else
        {
            return $string;
        }
    }
    public function searchForWhoIsWho($searchterm)
    {
        $person=[];
        //SEARCHING WHO IS WHO
        try
        {
            $response_whoiswho = $this->client->get(Config::get("kdg.intranet").'/wieiswie?q='.rawurlencode($searchterm).'&page=1&sort=a-z', [
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
        $whosiswhosearchhtml=HtmlDomParser::str_get_html($response_whoiswho->getBody()->getContents());
        if(!$whosiswhosearchhtml->find("div.modPerson",0))
        {
            return false;
        }
        $firstresult=$whosiswhosearchhtml->find("div.modPerson",0)->find("article",0)->find("header",0);
        $person["name"]=trim($firstresult->find("h1",0)->plaintext);
        $person["email"]=trim($firstresult->find("div.meta",0)->find("div.group2",0)->find("div.email",0)->find("div.value",0)->plaintext);
        $person["image"]=$firstresult->find("div.image",0)->find("div.graphic",0)->find("div.profilePicture",0)->find("img",0)->src;
        return $person;
    }
    public function getCampusInfo()
    {
        $campusinfo=[];
        try
        {
            $response_mainpage = $this->client->get('https://intranet.student.kdg.be/', [
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
        $mainpagehtml=HtmlDomParser::str_get_html($response_mainpage->getBody()->getContents());
        try
        {
            $response_campuspage = $this->client->get($mainpagehtml->find("div.modCampus",0)->find("a#pagemain_0_homefooter_0_MyStudyfieldRepeater_CampusLink_0",0)->href, [
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
        $campuspage_html=HtmlDomParser::str_get_html($response_campuspage->getBody()->getContents());
        $campusinfo["address"]=trim($campuspage_html->find('div.address',0)->find("div.value",0)->plaintext);
        $campusinfo["openinghours"]=$this->openingsHoursOfCampus($campuspage_html);
        return $campusinfo;
    }
    private function openingsHoursOfCampus($campuspage_html)
    {
        try
        {
            $response_openinhoursservice = $this->client->get(Config::get("kdg.openinghoursservice").$this->findEntityIdOfCampus($campuspage_html), [
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
        $openinghours_html=HtmlDomParser::str_get_html($response_openinhoursservice->getBody()->getContents());
        $table="<table border='1' style='width: 80%; margin: 0 auto'";
        $days=$openinghours_html->find("div.day");
        foreach($days as $day)
        {
            $table.="<tr>";
            $table.="<td>".trim($day->find("div.dayname",0)->plaintext)."</td>";
            if(trim($day->find("div.openings",0)->plaintext)=="")
            {
                $table.="<td>Gesloten</td>";
            }
            else
            {
                $table.="<td>".trim($day->find("div.openings",0)->plaintext)."</td>";
            }
            $table.="</tr>";
        }
        $table.="</table>";
        return $table;
    }
    private function findEntityIdOfCampus($campushtml)
    {
        $searchfor='enitiyid="';
        return substr($campushtml,strlen($searchfor)+strpos($campushtml,$searchfor),2);
    }

}