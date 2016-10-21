<?php

namespace App\Console\Commands;

use App\Mailers\ContactMailer;
use Illuminate\Console\Command;

class testNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crm:testNotification';

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
    public function __construct(ContactMailer $mailer)
    {
        parent::__construct();

        $this->mailer = $mailer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $task = \App\Task::find(7);
        $this->mailer->notificationTasks(['task'=> $task]);
    }
}
