<?php namespace App\Repositories;

use App\Project;
use Illuminate\Support\Facades\File;

class ProjectRepo extends DbRepo{



	/**
     * @param Client $model
     */
    function __construct(Project $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    public function store($data)
    {
        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'].'-'.getUniqueNumber(), 'projects', null, null, 640, null, false) : '';

      
        $project = $this->model->create($data);
       
        
       

        return $project;
    	
    }

    /**
     * Update a client
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $project = $this->model->findOrFail($id);

        $data['image'] = (isset($data['image'])) ? $this->storeImage($data['image'], $data['name'].'-'.getUniqueNumber(), 'properties', null, null, 640, null, false) : $project->image;
    
        $project->fill($data);
        $project->save();


        return $project;
    }

    /**
     * Delete a client by ID
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $project = $this->findById($id);
        $image_delete = $project->image;
        $project->delete();

        File::delete(dir_photos_path('projects') . $image_delete);
        File::delete(dir_photos_path('projects') . 'thumb_' . $image_delete);
       

        return $project;
    }
     /**
     * Get all the clients for the admin panel
     * @param $search
     * @return mixed
     */
    public function getAll($search)
    {
              
        $projects = $this->model;
        
       

        if (isset($search['q']) && ! empty($search['q']))
        {
            $projects = $projects->Search($search['q']);
        }
        if (isset($search['status']) && $search['status'] != "")
        {
            $projects = $projects->where('status', '=', $search['status']);
        }
        

 


        return $projects->with('properties')->orderBy('created_at', 'desc')->paginate($this->limit);
    }

    /**
     * Find a client by ID
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->model->with('properties')->findOrFail($id);
    }

    
}
