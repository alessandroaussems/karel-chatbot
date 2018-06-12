<?php

namespace App\Console\Commands;

use App\Services\KdGService;
use App\Session;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Nexmo\Laravel\Facade\Nexmo;

class DailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyupdate:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends all users an update regarding notifications and abscents';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sessions=Session::all();
        foreach($sessions as $session)
        {
            if(isset($session->login))
            {
                $KdGService=new KdGService();
                $KdGService->doLogin($session->login,openssl_decrypt($session->password,"AES-128-ECB",$_ENV['APP_KEY']));
                $data=new \stdClass();
                $data->email=$session->login;
                $data->name=$session->firstname;
                $data->sessionid=rawurlencode(openssl_encrypt($session->id,"AES-128-ECB",$_ENV['APP_KEY']));
                $data->notifications=$KdGService->getNotifications();
                $data->abscents=$KdGService->getAbscents();
                if($session->sendmail)
                {
                    Mail::send('mail.dailyupdate', ['data' => $data], function ($m) use ($data) {

                        $m->to($data->email)->subject('Dagelijkse update!');
                    });
                }
                if($session->sendsms)
                {
                    /*$notificationstring=". Meldingen: ";
                    $absenctstring="Afwezige docenten: ";
                    $phonenumber=$KdGService->getPhonenumber();
                    $phonenumber=preg_replace("/0/", "32", $phonenumber, 1); //Correct Nexmo format
                    foreach ($data->notifications as $i => $notification)
                    {
                        if($i!=0)
                        {
                            $notificationstring.=", ".$notification["title"];
                        }
                        else
                        {
                            $notificationstring.=$notification["title"];
                        }
                    }
                    foreach ($data->abscents as $j => $abscent)
                    {
                        if($j!=0)
                        {
                            $absenctstring.=", ".str_replace(" afwezig"," -> Afwezig",str_replace("  ","",trim(strip_tags($abscent))));
                        }
                        else
                        {
                            $absenctstring.=str_replace(" afwezig"," -> Afwezig",str_replace("  ","",trim(strip_tags($abscent))));
                        }
                    }
                    $text="Karel-Chatbot: Dit is je dagelijkse update! ".$absenctstring.$notificationstring . ". Surf naar: https://karel-chatbot.be/session?sessionid=". $data->sessionid." voor meer info! Om je uit te schrijven voor deze meldingen: https://karel-chatbot.be/notifications?sessionid=". $data->sessionid;
                    Nexmo::message()->send([
                    'to'   => $phonenumber,
                    'from' => '32471448210',
                    'text' =>  $text
                    ]);*/
                }
            }
        }
        return "Done!";
    }
}
