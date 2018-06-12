<?php

namespace App\Console\Commands;

use App\Services\KdGService;
use App\Session;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
        foreach ($sessions as $session)
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
                Mail::send('mail.dailyupdate', ['data' => $data], function ($m) use ($data) {

                    $m->to($data->email)->subject('Dagelijkse update!');
                });
            }
        }
        return "Done!";
    }
}
