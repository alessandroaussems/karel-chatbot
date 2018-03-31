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
    public function DoLogin()
    {
        $USER="";
        $PASS="";
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
        echo $response_intranet->getBody()->getContents();
        return;
    }
}