<?php namespace App\Repositories;

use App\Client;
use App\Profile;
use App\Role;
use App\User;
use Carbon\Carbon;


class SellerRepo extends DbRepo{



	/**
     * @param User $model (Seller)
     */
    function __construct(User $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    public function store($data)
    {
    	$data = $this->prepareData($data);
        
        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'].'-'.getUniqueNumber(), 'sellers', null, null, 640, null, false) : '';
        $seller = $this->model->create($data);
        $profile = new Profile($data);

        $seller->createProfile($profile);

        $role = (isset($data['role'])) ? $data['role'] : Role::whereName('seller')->firstOrFail();
        $seller->assignRole($role);
        
        if(isset($data['clients']))
            $seller->assignClient($data['clients']);

        return $seller;
    	
    }

     /**
     * Update a user
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|static
     */
    public function update($id, $data)
    {
        $seller = $this->model->findOrFail($id);
        $data = $this->prepareData($data);
       
        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'].'-'.getUniqueNumber(), 'sellers', null, null, 640, null, false) : $seller->profile->image;

        $seller->fill($data);
        $seller->save();
        $seller->profile->fill($data)->save();
        $seller->roles()->sync($data['role']);
        $seller->assignClient((isset($data['clients'])) ? $data['clients'] : [] );

        return $seller;
    }
      /**
     * Get all the sellers for the admin panel
     * @param $search
     * @return mixed
     */
    public function getAll($search)
    {
        
        $sellers = $this->model;
        

        if (isset($search['q']) && ! empty($search['q']))
        {
            $sellers = $sellers->Search($search['q']);
        }

 


        return $sellers->with('clients')->orderBy('created_at', 'desc')->paginate($this->limit);
    }

    /**
     * Find a seller by ID
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->with('clients')->findOrFail($id);
    }

    private function prepareData($data)
    {
        if(empty($data['password']))
           return $data = array_except($data, array('password'));

        $data['password'] = bcrypt($data['password']);

        
        
        return $data;
    }

    //List of seller for the modal view of seller.

    public function list_sellers($value = null, $search = null)
    {

        if ($search && $value != "")
            $sellers = ($value) ? $this->model->where('id', '<>', $value)->search($search)->paginate(8) : $this->model->paginate(8);
        else if ($value != "")
            $sellers = ($value) ? $this->model->where('id', '<>', $value)->paginate(8) : $this->model->paginate(8);
        else
            $sellers = $this->model->search($search)->paginate(8);

        return $sellers;
    }

    /**
     * Get all the clients for the admin panel
     * @param $search
     * @return mixed
     */
    public function reportsStatisticsSellers($search)
    {
        
         $order = 'created_at';
         $dir = 'desc';
        
         $sellers = $this->model->has('clients');
        
    
        
        if (isset($search['seller']) && $search['seller'] != "")
        {
            $sellers = $sellers->where('users.id', $search['seller']);
        }
      
       
        
        $statistics = [];
        $citas = 0; 
        $created = 0;  //clientes creados
        $reservados = 0; //clientes reservados
        $formalizados = 0;
        $aprobados = 0;
        $retirados = 0;
        $interesados = 0;
        $desinteresados = 0;

        $seller = $sellers->first();

        if($seller)
        {
            foreach ($seller->clients as $client) {

              

               if (isset($search['date1']) && $search['date1'] != "")
                {
                   
                    
                    
                    $date1 = new Carbon($search['date1']);
                    $date2 = (isset($search['date2']) && $search['date2'] != "") ? $search['date2'] : $search['date1'];
                    $date2 = new Carbon($date2);
        

                    if($client->cita && Carbon::parse($client->cita_date)->between($date1, $date2))
                    {
                      $citas += ($client->cita) ? 1 : 0;
                    }

                    if($client->created_at->between($date1, $date2))
                    {

                      $created +=  1;
                      $reservados += ($client->status == 1) ? 1 : 0;
                      $aprobados += ($client->status == 2) ? 1 : 0;
                      $interesados += ($client->status == 3) ? 1 : 0;
                      $formalizados +=  ($client->status == 4) ? 1 : 0;
                      $retirados +=  ($client->status == 5) ? 1 : 0;
                      $desinteresados +=  ($client->status == 6) ? 1 : 0;

                    }
                    
                 

                }else{

                     $created += 1 ;//$seller->clients->count();


                     $citas += ($client->cita) ? 1 : 0;

                    $reservados += ($client->status == 1) ? 1 : 0;
                    $aprobados += ($client->status == 2) ? 1 : 0;
                    $interesados += ($client->status == 3) ? 1 : 0;
                    $formalizados += ($client->status == 4) ? 1 : 0;
                    $retirados +=  ($client->status == 5) ? 1 : 0; 
                    $desinteresados +=  ($client->status == 6) ? 1 : 0;
                }


            }

            $statistics['created'] = $created;
            $statistics['citas'] = $citas;
            $statistics['reservados'] = $reservados;
            $statistics['aprobados'] = $aprobados;
            $statistics['interesados'] = $interesados;
            $statistics['retirados'] = $retirados;
            $statistics['desinteresados'] = $desinteresados;
            $statistics['formalizados'] = $formalizados;
        }
        
      return $statistics;
       
    }
     /**
     * Get all the clients for the admin panel
     * @param $search
     * @return mixed
     */
    public function reportsStatisticsSellersExcel($search)
    {
        
        $order = 'created_at';
         $dir = 'desc';
        
         $sellers = $this->model->has('clients');
        
    
        
        if (isset($search['fil-seller']) && $search['fil-seller'] != "")
        {
            $sellers = $sellers->where('users.id', $search['fil-seller']);
        }
      
       
        
        $statistics = [];
        $citas = 0; 
        $created = 0;  //clientes creados
        $reservados = 0; //clientes reservados
        $formalizados = 0;
        $aprobados = 0;
        $retirados = 0;
        $interesados = 0;
        $desinteresados = 0;

        $seller = $sellers->first();

        if($seller)
        {
            foreach ($seller->clients as $client) {

              

               if (isset($search['fil-date1']) && $search['fil-date1'] != "")
                {
                   
                    
                    
                    $date1 = new Carbon($search['fil-date1']);
                    $date2 = (isset($search['fil-date2']) && $search['fil-date2'] != "") ? $search['fil-date2'] : $search['fil-date1'];
                    $date2 = new Carbon($date2);
        

                    if($client->cita && Carbon::parse($client->cita_date)->between($date1, $date2))
                    {
                      $citas += ($client->cita) ? 1 : 0;
                    }

                    if($client->created_at->between($date1, $date2))
                    {

                      $created +=  1;
                      $reservados += ($client->status == 1) ? 1 : 0;
                      $aprobados += ($client->status == 2) ? 1 : 0;
                      $interesados += ($client->status == 3) ? 1 : 0;
                      $formalizados +=  ($client->status == 4) ? 1 : 0;
                      $retirados +=  ($client->status == 5) ? 1 : 0;
                      $desinteresados +=  ($client->status == 6) ? 1 : 0;

                    }
                    
                 

                }else{

                     $created += 1 ;//$seller->clients->count();


                     $citas += ($client->cita) ? 1 : 0;

                    $reservados += ($client->status == 1) ? 1 : 0;
                    $aprobados += ($client->status == 2) ? 1 : 0;
                    $interesados += ($client->status == 3) ? 1 : 0;
                    $formalizados += ($client->status == 4) ? 1 : 0;
                    $retirados +=  ($client->status == 5) ? 1 : 0; 
                    $desinteresados +=  ($client->status == 6) ? 1 : 0;
                }


            }

            $statistics['created'] = $created;
            $statistics['citas'] = $citas;
            $statistics['reservados'] = $reservados;
            $statistics['aprobados'] = $aprobados;
            $statistics['interesados'] = $interesados;
            $statistics['retirados'] = $retirados;
            $statistics['desinteresados'] = $desinteresados;
            $statistics['formalizados'] = $formalizados;
        }
        
      return $statistics;
    }
}
