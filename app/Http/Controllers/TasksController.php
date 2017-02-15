<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\TaskRepo;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;

class TasksController extends Controller
{
    
    function __construct(TaskRepo $taskRepo) {
        
        $this->middleware('auth', ['except' => [
            'notification'
        ]]);;

    	$this->taskRepo = $taskRepo;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $input = $request->all();
       
        $this->taskRepo->store($input);

        Flash('Tarea creada');

        return Redirect()->route('clients.edit',$input['client_id']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $task = $this->taskRepo->findById($id);

        return View('tasks.edit')->with(compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        
        $task = $this->taskRepo->update($id, $request->all());

        Flash('Tarea actualizada');

        return Redirect()->route('clients.edit', $task->client->id);
    }

     /**
     * complete task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function comp($id)
    {
        $task = $this->taskRepo->update_status($id, 1);

        return Redirect()->route('clients.edit', $task->client->id);
    }

    /**
     * pending task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function pend($id)
    {
        $task = $this->taskRepo->update_status($id, 0);

        return Redirect()->route('clients.edit', $task->client->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = $this->taskRepo->destroy($id);

        Flash('Tarea eliminada');

        return Redirect()->route('clients.edit', $task->client->id);
    }

    public function option_multiple(Request $request)
    {
        $clients_id = $request->input('chk_client');
        $action = $request->input('select_action');
       
        foreach ($clients_id as $id)
        {
            
            if($action == "delete")
                $this->clientRepo->destroy($id);

        }


        return Redirect()->route('clients');

    }
     public function notification(Request $request)
    {
        $exitCode = \Artisan::call('crm:tasksNotification');

        return $exitCode;
    }

}
