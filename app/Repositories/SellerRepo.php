<?php namespace App\Repositories;

use App\Role;
use App\User;
use App\Client;
use App\Profile;


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
}
