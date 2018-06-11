<?php
namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Sunra\PhpSimple\HtmlDomParser;

class KdGService
{
    private $client;
    private $cookieJar;
    /**
     * KdGService constructor.
     */
    public function __construct()
    {
        $this->client=new Client();
        $this->cookieJar=new \GuzzleHttp\Cookie\CookieJar();
    }
    /**
     * Indicates if user is succesfully logged in
     *
     * @param $USER
     * @param $PASS
     * @return bool
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
     * Indicates if user is succesfully logged in
     *
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
     * Returns name of the current user
     *
     * @return array ["firstname"] & ["lastname"]
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
        //RETURNING FULL NAME
        $name["firstname"]=trim($name_html->find("span.firstname",0)->plaintext);
        $name["lastname"]=trim($name_html->find("span.lastname",0)->plaintext);
        return $name;
    }
    /**
     * Returns the current user's notifications
     *
     * @return array of notifications with notification ["title"] & ["body"] & ["url"]
     */
    public function getNotifications()
    {
        $allnotifications=[];
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
            $notificationtoadd=[];
            $notificationtoadd["title"]=$notification->find("a",0)->plaintext;
            $notificationtoadd["body"]=$notification->find("div.textblock",0)->plaintext;
            $notificationtoadd["url"]=$notification->find("a",0)->href;

            array_push($allnotifications,$notificationtoadd);
        }
        return array_slice($allnotifications, 0, 3);

    }
    /**
     * Returns the current day menu for the main campus of the current user
     *
     * @return string
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
     * Return abscents for the main education of the current user
     *
     * @return string
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
    }
    /**
     * Returns the current printprices in a html table
     *
     * @return string
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
     * Returns the current users points for this year
     *
     * @return array ["nameofthelesson"] => value is the point on 20
     */
    public function getPoints()
    {
        $this->eStudentserviceAuthentication();
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
                    $points[$pointsrow->find("td",1)->plaintext]=$pointsrow->last_child()->prev_sibling()->plaintext;
                }
            }
        }
        return $points;
    }
    /**
     * Returns the current user's bulletinboard items
     *
     * @return array of bulletinitems ["title"] & ["sort"] & ["body"]
     */
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
    /**
     * Converts all links in a string to real clickable html links
     *
     * @param $string
     * @return string
     */
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
    /**
     * Search for the param on 'Wie is Wie'
     *
     * @param $searchterm
     * @return array ["name"] & ["email"] & ["image"] | bool
     */
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
        $person["image"]="/img/intranet/anonymous.png";
        $imgname=hash("sha256",time());
        try
        {
            $response_image = $this->client->get($firstresult->find("div.image",0)->find("div.graphic",0)->find("div.profilePicture",0)->find("img",0)->src, [
                    'allow_redirects' => true,
                    'cookies' => $this->cookieJar,
                    "sink" => "./img/intranet/".$imgname.".jpeg"
                ]
            );
            $person["image"]="/img/intranet/".$imgname.".jpeg";
        }
        catch (\Exception $e)
        {
            $person["image"]="/img/intranet/anonymous.png";
        }
        return $person;
    }
    /**
     * Returns more information about the main campus of the current user
     *
     * @return array ["address"] & ["openinghours"]
     */
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
    /**
     * Creates table of openinghours for a campus
     *
     * @param $campuspage_html
     * @return string
     */
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
    /**
     * Returns the entityid of the current user's main campus
     *
     * @param $campushtml
     * @return bool|string
     */
    private function findEntityIdOfCampus($campushtml)
    {
        $searchfor='enitiyid="';
        return substr($campushtml,strlen($searchfor)+strpos($campushtml,$searchfor),2);
    }
    /**
     * Returns the current user remaining studycredit
     *
     * @return string
     */
    public function getStudyCredit()
    {
        $this->eStudentserviceAuthentication();
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
        $credit=$estudent_html->find("div.card-lk-stand",0)->plaintext;
        return $credit;
    }
    /**
     * Returns the current user necessities for this year
     *
     * @return array of necessities ["title"] & ["details"] & ["lesson"] & ["period"]
     */
    public function getStudyNecessities()
    {
        $this->eStudentserviceAuthentication();
        $necessities=[];
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
        $necessitiesurl=$estudent_html->find("a.mnu",8)->href;
        try
        {
            $response_points = $this->client->get(Config::get("kdg.estudentservice").'/'.$necessitiesurl, [
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
        $necessitie_html=HtmlDomParser::str_get_html($response_points->getBody()->getContents());
        $necessitie_divs=$necessitie_html->find("div.StudMat-rechts");
        foreach ($necessitie_divs as $necessitie_div)
        {
            $necessitie=[];
            $necessitie["title"]=$necessitie_div->find("div.StudMat-titel",0)->plaintext;
            $necessitie["details"]=$necessitie_div->find("div.StudMat-details",0)->text();
            $necessitie["lesson"]=$necessitie_div->find("div.StudMat-olod",0)->plaintext;
            $necessitie["period"]=$necessitie_div->find("div#dStudMatOLODdetails",0)->plaintext;
            array_push($necessities,$necessitie);
        }
        return $necessities;
    }
    /**
     * Returns the current user's lessons of today
     *
     * @return array ["title"] & ["location"] & ["time"] | bool
     */
    public function getDayLessons()
    {
        $today=date('d');
        $todayslessons=[];
        $lessonsoptions=["UserId"=>$this->findUserId(),"NumberOfVisibleElements"=>-1,"RemainingTime"=>0];
        try
        {
            $response_lessons = $this->client->post(Config::get("kdg.lessons"), [
                    'allow_redirects' => true,
                    'cookies' => $this->cookieJar,
                    'content-type' => 'application/json',
                    'body'=> json_encode($lessonsoptions)
                ]
            );
        }
        catch (\Exception $e)
        {
            //die($e->getMessage());
            die ("Er ging iets mis! &#x1F62D");
        }
        $responseobject=json_decode($response_lessons->getBody()->getContents());
        if(count($responseobject->Days)==0)
        {
          return false;
        }
        foreach ($responseobject->Days as $day)
        {
            if(preg_replace('/\D/', '', $day->DayOfWeek)==$today)
            {
               $lesson=[];
               foreach ($day->Hours as $lessonobj)
               {
                    $lesson["title"]=$lessonobj->Title;
                    $lesson["location"]=$lessonobj->Location;
                    $lesson["time"]=$lessonobj->Time;
                    array_push($todayslessons,$lesson);
               }
            }
        }
        return $todayslessons;
    }
    /**
     * Returns the current user's userid
     *
     * @return bool|string
     */
    private function findUserId()
    {
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
        $searchfor="userId = '";
        return substr($mainpagehtml,strlen($searchfor)+strpos($mainpagehtml,$searchfor),24);
    }
    /**
     * Returns the current user's subjects with link to ECTS-fiche
     *
     * @return array of subjects ["title"] & ["ectslink"] & ["studypoints"]
     */
    public function getSubjectsWithECTSLink()
    {
        $this->eStudentserviceAuthentication();
        $allsubjects=[];
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
        $subjectsurl=$estudent_html->find("a.mnu",6)->href;
        try
        {
            $response_subjects = $this->client->get(Config::get("kdg.estudentservice").'/'.$subjectsurl, [
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
        $subjectshtml=HtmlDomParser::str_get_html($response_subjects->getBody()->getContents());
        $subjects=$subjectshtml->find("div.MSOLOD>div.MSLESOLOD");
        foreach ($subjects as $subject)
        {
            $asubject=[];
            $asubject["title"]=$subject->find("span",1)->plaintext;
            preg_match('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#',$subject->find("div.xOLODDetailIcon",0)->onclick,$linkfromdiv);
            $asubject["ectslink"]=$linkfromdiv[0];
            $asubject["studypoints"]=preg_replace('/\D/', '',$subject->find("div.studieomvang",0)->find('strong',0)->plaintext);
            array_push($allsubjects,$asubject);
        }
        return $allsubjects;
    }
    /**
     * Returns the current user's grade of merit
     *
     * @return array ["grade"] & ["meaning"]
     */
    public function getGradeOfMerit()
    {
        $this->eStudentserviceAuthentication();
        $totalofresultsmultipliedbystudypoints=0;
        $totalstudypoints=0;
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
        $studyoverviewurl=$estudent_html->find("a.mnu",7)->href;
        try
        {
            $response_studyoverview = $this->client->get(Config::get("kdg.estudentservice").'/'.$studyoverviewurl, [
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
        $studieoverview_html=HtmlDomParser::str_get_html($response_studyoverview->getBody()->getContents());
        $studieoverview_html=$studieoverview_html->find("table",2);
        $subjectsfromresulttable=$studieoverview_html->find("tr.rowBody");
        foreach ($subjectsfromresulttable as $subjectfromresulttable)
        {
            $studypoints=preg_replace('/^([^,]*).*$/', '$1', $subjectfromresulttable->find("td",3)->plaintext);
            if($subjectfromresulttable->find("td",9)->plaintext=="C")//CHECK IF PASSED FOR THE SUBJECTS
            {
                //IF PASSED GRAB RESULT
                $result=$subjectfromresulttable->find("td",8)->plaintext;
            }
            else
            {
                //IF NOT PASSED GRAB RESULT OF RETRY
                $result=$subjectfromresulttable->find("td",11)->plaintext;
            }
            if($result!="&nbsp;")
            {
                $multiply=intval($studypoints)*intval($result);
                $totalofresultsmultipliedbystudypoints+=$multiply;
                $totalstudypoints+=$studypoints;
            }
        }
        $gradeofmerit=$totalofresultsmultipliedbystudypoints/$totalstudypoints;
        $gradeofmerit*=5;
        $meaning="";
        if ($gradeofmerit>50)
        {
            $meaning="Voldoende";
        }
        if($gradeofmerit>65)
        {
            $meaning="Onderscheiding";
        }
        if($gradeofmerit>75)
        {
            $meaning="Grote onderscheiding";
        }
        if($gradeofmerit>85)
        {
            $meaning="Grootste onderscheiding";
        }
        return ["grade"=>round($gradeofmerit,0),"meaning"=>$meaning];
    }
    /**
     * Returns the current user's phone number
     *
     * @return string
     */
    public function getPhonenumber()
    {
        $this->eStudentserviceAuthentication();
        $phonenumber="";
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
        $userdataurl=$estudent_html->find("a.mnu",5)->href;
        try
        {
            $response_userdata = $this->client->get(Config::get("kdg.estudentservice").'/'.$userdataurl, [
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
        $userdatahtml=HtmlDomParser::str_get_html($response_userdata->getBody()->getContents());
        $userdata=$userdatahtml->find("div.md-item");
        foreach ($userdata as $data)
        {
            if(trim($data->find("span.md-label",0)->plaintext)=="Student:")
            {
                $phonenumber=preg_replace('/\D/', '', $data->find("span.md-value",0)->plaintext);
            }
        }
        return $phonenumber;
    }

}