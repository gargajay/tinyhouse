<?php
    
namespace App\Console\Commands;
use App\Models\User;
use Mail; 
use App\Models\calculation;
use Illuminate\Console\Command;
    
class LogCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:cron';
     
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
     
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
        $userArr = User::all();
       foreach ($userArr as $key => $user) {
              if ($user['user_type'] == 'user') {
                  $userObj = User::find($user['id']);
                  $myLogObj = new calculation;
                  $myLogObj->price = '100';
                  $myLogObj->well_name = '1';
                  $myLogObj->save();
             }
        } 
        \Log::info("Cron is working fine!");
    }
}
