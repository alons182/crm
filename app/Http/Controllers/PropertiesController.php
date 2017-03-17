<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\PropertyEditRequest;
use App\Http\Requests\PropertyRequest;
use App\Project;
use App\Repositories\PropertyRepo;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    
 	function __construct(PropertyRepo $propertyRepo) {
        $this->middleware('auth');
        
        $this->propertyRepo = $propertyRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $search = $request->all();
        $search['q'] = (isset($search['q'])) ? trim($search['q']) : '';
        $search['status'] = (isset($search['status'])) ? $search['status'] : '';
        $search['province'] = (isset($search['province'])) ? $search['province'] : '';
       
        $properties = $this->propertyRepo->getAll($search);

        return View('properties.index')->with([
            'properties'         => $properties,
            'search'           => $search['q'],
            'selectedStatus'   => $search['status'], 
            'selectedLocation'   => $search['province'] 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PropertyRequest $request)
    {
       
        $input = $request->all();
        $input['user_id'] =  auth()->user()->id; 
          
        $property = $this->propertyRepo->store($input);

        Flash('Propiedad creada');

        return Redirect('/projects/'.$property->project_id.'/edit');//Redirect()->route('properties');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*if(! auth()->user()->can('edit_sellers'))
            return Redirect()->route('dashboard');
        */

        $property = $this->propertyRepo->findById($id);

        return View('properties.edit')->with(compact('property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PropertyEditRequest $request, $id)
    {
        
        $input = $request->all();//only('name', 'email', 'password', 'password_confirmation','role');
        
       $property =  $this->propertyRepo->update($id, $input);

        Flash('Propiedad actualizada');

        return Redirect('/projects/'.$property->project_id.'/edit');//Redirect()->route('properties');
    }

    /**
     * complete task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function sold($id)
    {
        $property = $this->propertyRepo->update_status($id, 2);

        return Redirect('/projects/'.$property->project_id.'/edit');//return Redirect()->route('properties');
    }
    /**
     * complete task.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function free($id)
    {
        $property = $this->propertyRepo->update_status($id, 1);

        return Redirect('/projects/'.$property->project_id.'/edit');//return Redirect()->route('properties');
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
        $property = $this->propertyRepo->update_status($id, 0);

        return Redirect('/projects/'.$property->project_id.'/edit'); //return Redirect()->route('properties');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $property = $this->propertyRepo->destroy($id);

        Flash('Propiedad eliminda');

        return Redirect('/projects/'.$property->project_id.'/edit');//return Redirect()->route('properties');
    }

     public function option_multiple(Request $request)
    {
        $properties_id = $request->input('chk_property');
        $action = $request->input('select_action');
       
        foreach ($properties_id as $id)
        {
            
            if($action == "delete")
                $property = $this->propertyRepo->destroy($id);

        }


        return Redirect('/projects/'.$property->project_id.'/edit');//return Redirect()->route('properties');

    }

      /**
     * List of sellers for the modal view in seller sections
     * @param Request $request
     * @return mixed
     */
    public function list_properties(Request $request)
    {
        return $this->propertyRepo->list_properties($request->input('exc_id'), $request->input('key'));
    }

    public function propertiesByProject(Request $request)
    {
        $project = Project::find($request->input('project_id'));

        $client_id = $request->input('client_id');
        //para saber cuales propiedades de este proyecto ya estan asignadas
        if($client_id){
            $propertiesWithClientsAssigned = ($project) ? $project->properties()->whereHas('clients', function ($query) use($client_id) {
                    $query->where('clients.id', '<>', $client_id);
                })->pluck('id')->all() : null;

        }else{
            $propertiesWithClientsAssigned = ($project) ? $project->properties()->has('clients')->pluck('id')->all() : null;
        }
        
        
        $propertiesOfSelectedProject = ($project) ? $project->properties()->whereNotIn('id', $propertiesWithClientsAssigned)->get() : null;

        return $propertiesOfSelectedProject;
    }
}
