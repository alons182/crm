<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Http\Requests;
use App\Http\Requests\RequirementRequest;
use App\Repositories\RequirementRepo;
use Illuminate\Http\Request;

class RequirementsController extends Controller
{
    function __construct(RequirementRepo $requirementRepo) {
        $this->middleware('auth');
        
        $this->requirementRepo = $requirementRepo;
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
        
        
       
        $requirements = $this->requirementRepo->getAll($search);

        return View('requirements.index')->with([
            'requirements'         => $requirements,
            'search'           => $search['q']
           
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('requirements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequirementRequest $request)
    {
        $input = $request->all();
       
        $requirement = $this->requirementRepo->store($input);

        Flash('Requerimiento creado');

        return Redirect('/banks/'.$requirement->bank->id.'/edit');
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

        $requirement = $this->requirementRepo->findById($id);

        return View('requirements.edit')->with(compact('requirement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequirementRequest $request, $id)
    {
        
        $input = $request->all();//only('name', 'email', 'password', 'password_confirmation','role');
        
        $requirement = $this->requirementRepo->update($id, $input);

        Flash('Requerimiento actualizado');

       return Redirect('/banks/'.$requirement->bank->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $requirement = $this->requirementRepo->destroy($id);

        Flash('Requerimiento eliminado');

         return Redirect('/banks/'.$requirement->bank->id.'/edit');
    }

     public function option_multiple(Request $request)
    {
        $requirements_id = $request->input('chk_requirement');
        $action = $request->input('select_action');
       
        foreach ($requirements_id as $id)
        {
            
            if($action == "delete")
                $requirement = $this->requirementRepo->destroy($id);

        }


         return Redirect('/banks/'.$requirement->bank->id.'/edit');

    }

    public function requirementsByBank(Request $request)
    {
        $bank = Bank::find($request->input('bank_id'));

        return $bank->requirements()->get();
    }

  
}
