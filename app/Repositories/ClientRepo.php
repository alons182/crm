<?php namespace App\Repositories;

use App\Client;
use Illuminate\Support\Facades\File;

class ClientRepo extends DbRepo{



	/**
     * @param Client $model
     */
    function __construct(Client $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    public function store($data)
    {

        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['fullname'].'-'.getUniqueNumber(), 'clients', null, null, 640, null, false) : '';

        $client = $this->model->create($data);
        
        if(isset($data['sellers']))
            $client->assignSeller($data['sellers']);

        return $client;
    	
    }

    /**
     * Update a client
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $client = $this->model->findOrFail($id);
        
        
        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['fullname'].'-'.getUniqueNumber(), 'clients', null, null, 640, null, false) : $client->image;

        $client->fill($data);
        $client->save();

        $client->assignSeller((isset($data['sellers'])) ? $data['sellers'] : [] );
       
        return $client;
    }

    /**
     * Delete a client by ID
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $client = $this->findById($id);
        $image_delete = $client->image;
        $client->delete();

        File::delete(dir_photos_path('clients') . $image_delete);
        File::delete(dir_photos_path('clients') . 'thumb_' . $image_delete);
       

        return $client;
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
        return $this->model->with('sellers')->findOrFail($id);
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
