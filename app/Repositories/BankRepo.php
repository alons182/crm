<?php namespace App\Repositories;

use App\Bank;
use Illuminate\Support\Facades\File;

class BankRepo extends DbRepo{



	/**
     * @param Client $model
     */
    function __construct(Bank $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    public function store($data)
    {
       
      
        $bank = $this->model->create($data);
           


        return $bank;
    	
    }

    /**
     * Update a client
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $bank = $this->model->findOrFail($id);
    
        $bank->fill($data);
        $bank->save();


        return $bank;
    }

    /**
     * Delete a client by ID
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $bank = $this->findById($id);
        $bank->delete();


        return $bank;
    }
     /**
     * Get all the clients for the admin panel
     * @param $search
     * @return mixed
     */
    public function getAll($search)
    {
              
        $banks = $this->model;
        
       

        if (isset($search['q']) && ! empty($search['q']))
        {
            $banks = $banks->Search($search['q']);
        }
       


        return $banks->with('requirements')->orderBy('created_at', 'desc')->paginate($this->limit);
    }

    /**
     * Find a client by ID
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->with('requirements')->findOrFail($id);
    }

    
}
