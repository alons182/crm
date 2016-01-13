<?php namespace App\Repositories;


use App\Task;
use App\Client;
use Illuminate\Support\Facades\File;

class TaskRepo extends DbRepo{



	/**
     * @param Client $model
     */
    function __construct(Task $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    public function store($data)
    {


        $task = $this->model->create($data);
        

        return $task;
    	
    }

    /**
     * Update a client
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $task = $this->model->findOrFail($id);
        
        
       
        $task->fill($data);
        $task->save();

       
        return $task;
    }

    /**
     * Delete a client by ID
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $task = $this->findById($id);
       
        $task->delete();


        return $task;
    }
     /**
     * Get all the clients for the admin panel
     * @param $search
     * @return mixed
     */
    public function getAll($search)
    {
        
        $clients = $this->model;
        

        if (isset($search['q']) && ! empty($search['q']))
        {
            $clients = $clients->Search($search['q']);
        }

 


        return $clients->with('sellers')->orderBy('created_at', 'desc')->paginate($this->limit);
    }

    /**
     * Find a client by ID
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

      //List of seller for the modal view of seller.

    public function list_clients($value = null, $search = null)
    {

        if ($search && $value != "")
            $clients = ($value) ? $this->model->where('id', '<>', $value)->search($search)->paginate(8) : $this->model->paginate(8);
        else if ($value != "")
            $clients = ($value) ? $this->model->where('id', '<>', $value)->paginate(8) : $this->model->paginate(8);
        else
            $clients = $this->model->search($search)->paginate(8);

        return $clients;
    }
}
