<?php namespace App\Repositories;

use App\Client;
use App\User;
use Carbon\Carbon;
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
       // $data = $this->prepareData($data);

        $data['image'] = (isset($data['image']) && $data['image']) ? $this->storeImage($data['image'], $data['fullname'].'-'.getUniqueNumber(), 'clients', null, null, 640, null, false) : '';

        $client = $this->model->create($data);
        
        if(isset($data['sellers']))
            $client->assignSeller($data['sellers']);

        if(isset($data['properties']))
            $client->assignProperty($data['properties']);

        return $client;
    	
    }
    private function prepareData($data)
    {
        //$data['ide'] = str_replace(' ', '', $data['ide']);
        
       $data['referred_others'] = (isset($data['referred_others'])) ? $data['referred_others'] : '';
   

        return $data;
    }

    /**
     * Update a client
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $data = $this->prepareData($data);

        $client = $this->model->findOrFail($id);
        
        
        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['fullname'].'-'.getUniqueNumber(), 'clients', null, null, 640, null, false) : $client->image;

        $client->fill($data);
        $client->save();

        $client->assignSeller((isset($data['sellers'])) ? $data['sellers'] : [] );
        $client->assignProperty((isset($data['properties'])) ? $data['properties'] : [] );
       
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
        if(auth()->user()->hasRole('admin'))       
            $clients = $this->model;
        else
            $clients = auth()->user()->clients();
        
        if (isset($search['seller']) && $search['seller'] != "")
        {
            $seller = User::find($search['seller']);
            
            $clients = $seller->clients();
            //dd($clients);
        }
        if (isset($search['q']) && ! empty($search['q']))
        {
            $clients = $clients->Search($search['q']);
        }
         if (isset($search['referred']) && $search['referred'] != "")
        {
            $clients = $clients->where('referred', '=', $search['referred']);
        }
         if (isset($search['status']) && $search['status'] != "")
        {
            $clients = $clients->where('status', $search['status']);
        }

        if (isset($search['date1']) && $search['date1'] != "")
        {
           
            
            
            $date1 = new Carbon($search['date1']);
            $date2 = (isset($search['date2']) && $search['date2'] != "") ? $search['date2'] : $search['date1'];
            $date2 = new Carbon($date2);
            
           // dd($date2->endOfDay());
            $clients = $clients->where([['created_at', '>=', $date1],
                    ['created_at', '<=', $date2->endOfDay()]]);
            
        }
        


 


        return $clients->with('sellers')->orderBy('created_at', 'desc')->paginate($this->limit);
    }
    public function getColumnsName()
    {
        $fields = $this->model->getFillable(); ///\Schema::getColumnListing('clients');
        
        $fields = array_except($fields, ['12']); // remove image field
       
       return $fields;
    }
    public function reportClients($fields, $filters)
    {
        if(auth()->user()->hasRole('admin'))       
            $clients = $this->model;
        else
            $clients = auth()->user()->clients();

        if (isset($filters['fil-seller']) && $filters['fil-seller'] != "")
        {
            $seller = User::find($filters['fil-seller']);
            
            $clients = $seller->clients();
            //dd($clients);
        }
        if (isset($filters['fil-q']) && ! empty($filters['fil-q']))
        {
            $clients = $clients->Search($filters['fil-q']);
        }
         if (isset($filters['fil-referred']) && $filters['fil-referred'] != "")
        {
            $clients = $clients->where('referred', '=', $filters['fil-referred']);
        }
         if (isset($filters['fil-status']) && $filters['fil-status'] != "")
        {
            $clients = $clients->where('status', $filters['fil-status']);
        }

        if (isset($filters['fil-date1']) && $filters['fil-date1'] != "")
        {
           
            
            
            $date1 = new Carbon($filters['fil-date1']);
            $date2 = (isset($filters['fil-date2']) && $filters['fil-date2'] != "") ? $filters['fil-date2'] : $filters['fil-date1'];
            $date2 = new Carbon($date2);
            
           // dd($date2->endOfDay());
            $clients = $clients->where([['created_at', '>=', $date1],
                    ['created_at', '<=', $date2->endOfDay()]]);
            
        }

        $clients = ($fields) ? $clients->select($fields)->orderBy('created_at', 'desc')->get() : $clients->orderBy('created_at', 'desc')->get();
       
       return $clients;
    }
    /**
     * Find a client by ID
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
         if(auth()->user()->hasRole('admin'))       
            $client = $this->model->with('sellers')->findOrFail($id);
        else
            $client = auth()->user()->clients()->with('sellers')->findOrFail($id);
        
        return $client;
    }

      //List of seller for the modal view of seller.

    public function list_clients($value = null, $search = null)
    {

        if ($search && $value != "")
            $clients = ($value) ? $this->model->with('sellers')->where('id', '<>', $value)->search($search)->paginate(8) : $this->model->paginate(8);
        else if ($value != "")
            $clients = ($value) ? $this->model->with('sellers')->where('id', '<>', $value)->paginate(8) : $this->model->paginate(8);
        else
            $clients = $this->model->with('sellers')->search($search)->paginate(8);

        return $clients;
    }
}
