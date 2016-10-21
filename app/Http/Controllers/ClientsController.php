<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ClientEditRequest;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\ImportRequest;
use App\Property;
use App\Repositories\ClientRepo;
use App\Repositories\SellerRepo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Excel;

class ClientsController extends Controller
{
    function __construct(ClientRepo $clientRepo, SellerRepo $sellerRepo) {
        $this->middleware('auth');
        
        $this->clientRepo = $clientRepo;
         $this->sellerRepo = $sellerRepo;
        
        
        $properties = $this->groupedSelect();
 
      
        View::share('properties', $properties);
    }

    private function groupedSelect()
    {
        if(!auth()->user()->hasRole('admin'))
            $properties = auth()->user()->properties()->where('status',1);
         else
            $properties = Property::where('status',1);

        $select_optgroup_arr_properties = [];

        foreach ($properties->get() as $item)
        {
            $select_optgroup_arr_properties[$item->province][$item->id] = $item->name;
        }
        
        return $select_optgroup_arr_properties;
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
        $search['referred'] = (isset($search['referred'])) ? $search['referred'] : '';
        $search['seller'] = (isset($search['seller'])) ? $search['seller'] : '';
        $search['status'] = (isset($search['status'])) ? $search['status'] : '';
        $search['date1'] = (isset($search['date1'])) ? $search['date1'] : '';
        $search['date2'] = (isset($search['date2'])) ? $search['date2'] : '';
        
       
        $clients = $this->clientRepo->getAll($search);
        $sellers = User::lists('name','id')->all();
        $fieldsToExport = $this->clientRepo->getColumnsName();
        
        return View('clients.index')->with([
            'clients'         => $clients,
            'search'           => $search['q'],
            'selectedReference' =>  $search['referred'],
            'selectedSeller' =>  $search['seller'],
            'sellers'           => $sellers,
            'selectedStatus' =>  $search['status'],
            'date1'           => $search['date1'],
            'date2'           => $search['date2'],
            'fieldsToExport'   => $fieldsToExport
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

    public function import(Excel $excel, ImportRequest $request)
    {
        $file = $request->file('excel');//Input::file('excel');
        //dd($file);

        if(!$file) {Flash('Seleccione un archivo!!'); return Redirect()->route('clients');}

        $excel->load($file, function($reader) {
           
            foreach ($reader->get() as $client) {

                // para evitar en los campos que no se permiten null poner en blanco
                $data = array_map(function($v){
                    return (is_null($v)) ? "" : $v;
                },$client->toArray());
               
               /* $data = [
                    'name' => $client->title,
                    'author' =>$client->author,
                    'year' =>$client->publication_year
                ];*/
                 $this->clientRepo->store($data);
            }
        });
        //return Book::all();
         Flash('Imported !!');

         return Redirect()->route('clients');
    }
    public function export(Excel $excel, Request $request)
    {
        $data = $request->all();
        $fields = array_where($data, function ($key, $value) {
            return starts_with($key,'exp-');
        });
        $filters = array_where($data, function ($key, $value) {
            return starts_with($key,'fil-');
        });
        

        \Excel::create('Clients', function ($excel) use ($fields,$filters)
        {

            $excel->sheet('Clientes', function ($sheet) use ($fields, $filters)
            {
                //dd($this->clientRepo->reportClients($fields, $filters)->toArray());
                $clients = $this->clientRepo->reportClients($fields, $filters);
                
                $data = array_map(function($data){
                    
                      $data['status'] = \Lang::get('utils.status_client.'. $data['status']);

                    return $data;
                },$clients->toArray());
                
            
                $sheet->fromArray($data, null, 'A1', true);

            });


        })->export('xls');
    }


}
