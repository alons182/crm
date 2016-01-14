<?php

namespace App\Http\Controllers;

use App\Property;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\ClientRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\View;
use App\Http\Requests\ClientEditRequest;

class ClientsController extends Controller
{
    function __construct(ClientRepo $clientRepo) {
        $this->middleware('auth');
        
        $this->clientRepo = $clientRepo;
        View::share('properties', Property::where('status',1)->pluck('name', 'id')->all());
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
       
       
        $clients = $this->clientRepo->getAll($search);

        return View('clients.index')->with([
            'clients'         => $clients,
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
        return View('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
       
        $input = $request->all();

        $this->clientRepo->store($input);

        Flash('Client Created');

        return Redirect()->route('clients');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = $this->clientRepo->findById($id);
        $selectedProperties = $client->properties()->pluck('id')->all();

        return View('clients.edit')->with(compact('client','selectedProperties'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientEditRequest $request, $id)
    {
         $this->clientRepo->update($id, $request->all());

        Flash('Updated Client');

        return Redirect()->route('clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->clientRepo->destroy($id);

        Flash('Client Deleted');

        return Redirect()->route('clients');
    }

    public function option_multiple(Request $request)
    {
        $clients_id = $request->input('chk_client');
        $action = $request->input('select_action');
       
        foreach ($clients_id as $id)
        {
            
            if($action == "delete")
                $this->clientRepo->destroy($id);

        }


        return Redirect()->route('clients');

    }
     /**
     * List of clients for the modal view in seller sections
     * @param Request $request
     * @return mixed
     */
    public function list_clients(Request $request)
    {
        return $this->clientRepo->list_clients($request->input('exc_id'), $request->input('key'));
    }



     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_task($client_id)
    {
        
        return View('tasks.create')->with(compact('client_id'));
    }


}
