<?php

namespace App\Console\Commands;

use App\Mailers\ContactMailer;
use App\Repositories\TaskRepo;
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

    private $mailer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskRepo $taskRepo)
    {
        parent::__construct();

        $this->taskRepo = $taskRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $task = \App\Task::find(7);
        $this->taskRepo->sendNotification($task);
    }
}
