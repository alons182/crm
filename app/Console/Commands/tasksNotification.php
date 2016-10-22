<?php

namespace App\Console\Commands;

use App\Mailers\ContactMailer;
use App\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class tasksNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crm:tasksNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificacion de tareas de los vendedores';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContactMailer $mailer)
    {
        $this->mailer = $mailer;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tasks = Task::all();
        $countNotification = 0;

        foreach($tasks as $task)
        {
           if($task->notification_time && $task->notification_reminder_time)
           {
               
               $timeArray = explode(':', $task->notification_reminder_time);

               
               $dtTask = Carbon::createFromFormat('Y-m-d H:i:s', $task->notification_reminder_date);
               $dtTask->setTime($timeArray[0], $timeArray[1], 0);
              
              
                if(Carbon::now()->diffInMinutes($dtTask) == 0)
                {
                    
                    try {
                        $this->mailer->notificationTasks(['task'=> $task]);
                        
                    }catch (Swift_RfcComplianceException $e)
                    {
                        Log::error($e->getMessage());
                    }

                    $countNotification++;
                    
                    Log::info(Carbon::now()->diffInMinutes($dtTask));
                }
                

        
            }

        }
        Log::info($countNotification.' notificaciones enviadas' );
        $this->info('Hecho, ' . $countNotification.' notificaciones enviadas');
       
        
    }
}
