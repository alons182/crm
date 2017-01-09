<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\BankRequest;
use App\Repositories\BankRepo;
use Illuminate\Http\Request;

class BanksController extends Controller
{
    function __construct(BankRepo $bankRepo) {
        $this->middleware('auth');
        
        $this->bankRepo = $bankRepo;
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
        
        
       
        $banks = $this->bankRepo->getAll($search);

        return View('banks.index')->with([
            'banks'         => $banks,
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
        return View('banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankRequest $request)
    {
        $input = $request->all();
       
        $bank = $this->bankRepo->store($input);

        Flash('Banco creado');

        return Redirect('/banks/'.$bank->id.'/edit');
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

        $bank = $this->bankRepo->findById($id);

        return View('banks.edit')->with(compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BankRequest $request, $id)
    {
        
        $input = $request->all();//only('name', 'email', 'password', 'password_confirmation','role');
        
        $this->bankRepo->update($id, $input);

        Flash('Banco actualizado');

        return Redirect()->route('banks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $this->bankRepo->destroy($id);

        Flash('Banco eliminado');

        return Redirect()->route('banks');
    }

     public function option_multiple(Request $request)
    {
        $banks_id = $request->input('chk_bank');
        $action = $request->input('select_action');
       
        foreach ($banks_id as $id)
        {
            
            if($action == "delete")
                $this->bankRepo->destroy($id);

        }


        return Redirect()->route('banks');

    }

  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_requirement($bank_id)
    {
        if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager'))
            return back();

        return View('requirements.create')->with(compact('bank_id'));
    }
}
