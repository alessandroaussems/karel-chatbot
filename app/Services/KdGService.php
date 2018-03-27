<?php
namespace App\Services;
use GuzzleHttp\Client;

class KdGService
{
    public function DoLogin()
    {
        $client = new Client();
        $cookieJar = new \GuzzleHttp\Cookie\CookieJar();

        $response = $client->post('https://bb.kdg.be/webapps/login/', [
                'allow_redirects' => true,
                'form_params' => [
                    'user_id' => "",
                    'password' => "",
                    'action' => 'login'
                ],
            ]
        );

        $xml = $response->getBody()->getContents();
        return $xml;
    }
}