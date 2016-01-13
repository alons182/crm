<?php namespace App\Repositories;

use App\Property;
use Illuminate\Support\Facades\File;

class PropertyRepo extends DbRepo{



	/**
     * @param Client $model
     */
    function __construct(Property $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    public function store($data)
    {
        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'].'-'.getUniqueNumber(), 'properties', null, null, 640, null, false) : '';

      
        $property = $this->model->create($data);
       
        
        if(isset($data['clients']))
            $property->assignClient($data['clients']);

        return $property;
    	
    }

    /**
     * Update a client
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $property = $this->model->findOrFail($id);

        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'].'-'.getUniqueNumber(), 'properties', null, null, 640, null, false) : $property->image;
    
        $property->fill($data);
        $property->save();

        $property->assignClient((isset($data['clients'])) ? $data['clients'] : [] );

        return $property;
    }

    /**
     * Delete a client by ID
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $property = $this->findById($id);
        $image_delete = $property->image;
        $property->delete();

        File::delete(dir_photos_path('properties') . $image_delete);
        File::delete(dir_photos_path('properties') . 'thumb_' . $image_delete);
       

        return $property;
    }
     /**
     * Get all the clients for the admin panel
     * @param $search
     * @return mixed
     */
    public function getAll($search)
    {
        if(auth()->user()->hasRole('admin'))       
            $properties = $this->model;
        else
            $properties = auth()->user()->properties();
        

        if (isset($search['q']) && ! empty($search['q']))
        {
            $properties = $properties->Search($search['q']);
        }
        if (isset($search['status']) && $search['status'] != "")
        {
            $properties = $properties->where('status', '=', $search['status']);
        }

 


        return $properties->with('clients')->orderBy('created_at', 'desc')->paginate($this->limit);
    }

    /**
     * Find a client by ID
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->with('clients')->findOrFail($id);
    }

      //List of seller for the modal view of seller.

    public function list_properties($value = null, $search = null)
    {

        if ($search && $value != "")
            $properties = ($value) ? $this->model->where('id', '<>', $value)->search($search)->paginate(8) : $this->model->paginate(8);
        else if ($value != "")
            $properties = ($value) ? $this->model->where('id', '<>', $value)->paginate(8) : $this->model->paginate(8);
        else
            $properties = $this->model->search($search)->paginate(8);

        return $properties;
    }
}
