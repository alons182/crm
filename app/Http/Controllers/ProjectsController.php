<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ProjectRequest;
use App\Repositories\ProjectRepo;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    function __construct(ProjectRepo $projectRepo) {
        $this->middleware('auth');
        
        $this->projectRepo = $projectRepo;
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
        
       
        $projects = $this->projectRepo->getAll($search);

        return View('projects.index')->with([
            'projects'         => $projects,
            'search'           => $search['q'],
            'selectedStatus'   => $search['status'], 
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $input = $request->all();
        $input['user_id'] =  auth()->user()->id; 
          
        $project = $this->projectRepo->store($input);

        Flash('Proyecto creado');

        return Redirect('/projects/'.$project->id.'/edit');
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

        $project = $this->projectRepo->findById($id);

        return View('projects.edit')->with(compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        
        $input = $request->all();//only('name', 'email', 'password', 'password_confirmation','role');
        
        $this->projectRepo->update($id, $input);

        Flash('Proyecto actualizado');

        return Redirect()->route('projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $this->projectRepo->destroy($id);

        Flash('Proyecto elimindad');

        return Redirect()->route('projects');
    }

     public function option_multiple(Request $request)
    {
        $projects_id = $request->input('chk_project');
        $action = $request->input('select_action');
       
        foreach ($projects_id as $id)
        {
            
            if($action == "delete")
                $this->projectRepo->destroy($id);

        }


        return Redirect()->route('projects');

    }

  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_property($project_id)
    {
        if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager'))
            return back();

        return View('properties.create')->with(compact('project_id'));
    }
}
