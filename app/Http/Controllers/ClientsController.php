<?php

namespace App\Http\Controllers;

use App\Abono;
use App\Bank;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ClientEditRequest;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\ImportRequest;
use App\Project;
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
 
      
        View::share('properties', Property::where('status',1)->pluck('name','id')->all());
        View::share('projects', Project::where('status',1)->pluck('name','id')->all());
        View::share('banks', Bank::pluck('name','id')->all());
    }

    private function groupedSelect()
    {
        /*if(!auth()->user()->hasRole('admin'))
            $properties = auth()->user()->properties()->where('status',1);
         else*/
            $properties = Property::where('status',1);

        $select_optgroup_arr_properties = [];

        foreach ($properties->get() as $item)
        {
            //$select_optgroup_arr_properties[$item->province][$item->id] = $item->name;
            $select_optgroup_arr_properties[] = $item->name;
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
        //$search['debts'] = (isset($search['debts'])) ? $search['debts'] : '';
        $search['project'] = (isset($search['project'])) ? $search['project'] : '';
        $search['potencial'] = (isset($search['potencial'])) ? $search['potencial'] : '';
        $search['date1'] = (isset($search['date1'])) ? $search['date1'] : '';
        $search['date2'] = (isset($search['date2'])) ? $search['date2'] : '';
        $search['cita'] = (isset($search['cita'])) ? $search['cita'] : '';
        $search['reservation_paid'] = (isset($search['reservation_paid'])) ? $search['reservation_paid'] : '';
        
       
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
            'selectedProject' =>  $search['project'],
            //'selectedDebts' =>  $search['debts'],
            'selectedPotencial' =>  $search['potencial'],
            'date1'           => $search['date1'],
            'date2'           => $search['date2'],
            'selectedCita' =>  $search['cita'],
            'selectedReservationPaid' =>  $search['reservation_paid'],
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
       
        $client = $this->clientRepo->store($input);

       if(isset($input['commentsfromcreate'])) //esto para crear comentario cuando el cliente no ha sid guardado
       {
            foreach ($input['commentsfromcreate'] as $comment) {
                $data['body'] = $comment;
                $data['client_id'] = $client->id;
                $data['user_id'] = auth()->id();

                Comment::create($data);
            }
                
        }
         if(isset($input['abonosfromcreate'])) //esto para crear abonos cuando el cliente no ha sid guardado
       {
            foreach ($input['abonosfromcreate'] as $abono) {
                $porciones = explode("|", $abono);
                $data['amount'] = $porciones[0];
                $data['client_id'] = $client->id;
                $data['description'] = $porciones[1];

                Abono::create($data);
            }
                
        }
       
        
        Flash('Cliente creado');

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
       
        $selectedProject = Project::find($client->project);

        
        //para saber cuales propiedades de este proyecto ya estan asignadas
        $propertiesWithClientsAssigned = ($selectedProject) ? $selectedProject->properties()->whereHas('clients', function ($query) use($id) {
                    $query->where('clients.id', '<>', $id);
                })->pluck('id')->all() : null;

        
        
        $propertiesOfSelectedProject = ($selectedProject) ? $selectedProject->properties()->whereNotIn('id', $propertiesWithClientsAssigned)->pluck('name','id')->all() : null;

        //dd($propertiesOfSelectedProject);

        $selectedProperties =  $client->properties()->pluck('id')->all();

        
        $selectedBank = Bank::find($client->bank);
        
        $requirementsOfSelectedBank = ($selectedBank) ? $selectedBank->requirements()->pluck('name','id')->all() : null;

        $selectedRequirements =  $client->requirements()->pluck('id')->all();

        $selectedBank2 = Bank::find($client->bank2);
        
        $requirementsOfSelectedBank2 = ($selectedBank2) ? $selectedBank2->requirements()->pluck('name','id')->all() : null;

        //$selectedRequirements =  $client->requirements()->pluck('id')->all();
        //dd($selectedProperties);
        
        return View('clients.edit')->with(compact('client','selectedProperties','propertiesOfSelectedProject','selectedRequirements','requirementsOfSelectedBank','requirementsOfSelectedBank2'));
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

        Flash('Cliente actualizado');

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

        Flash('Cliente eliminado');

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
        if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('manager') && !auth()->user()->isAsigned($client_id))
            return back();

        return View('tasks.create')->with(compact('client_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comments(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();

        Comment::create($data);
        
       
        $comments = Comment::where('client_id',$request->input('client_id'))->with('user')->orderBy('created_at', 'desc')->get();

        return $comments;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateComments(Request $request)
    {

        $comment = Comment::find($request->input('id'));
        $comment->fill($request->all());
        $comment->save();
       
       
        $comments = Comment::where('client_id',$comment->client_id)->with('user')->orderBy('created_at', 'desc')->get();

        return $comments;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteComments(Request $request)
    {
        
        $comment = Comment::find($request->input('id'));
        $client_id = $comment->client_id;
        
        $comment->delete();

        $comments = Comment::where('client_id',$client_id)->with('user')->orderBy('created_at', 'desc')->get();

        return $comments;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function abonos(Request $request)
    {
        
        Abono::create($request->all());
        
       
        $abonos = Abono::where('client_id',$request->input('client_id'))->orderBy('created_at', 'desc')->get();

        return $abonos;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAbonos(Request $request)
    {

        $abono = Abono::find($request->input('id'));
        $abono->fill($request->all());
        $abono->save();
       
       
        $abonos = Abono::where('client_id',$abono->client_id)->orderBy('created_at', 'desc')->get();

        return $abonos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAbonos(Request $request)
    {
        
        $abono = Abono::find($request->input('id'));
        $client_id = $abono->client_id;
        
        $abono->delete();

        $abonos = Abono::where('client_id',$client_id)->orderBy('created_at', 'desc')->get();

        return $abonos;
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
         Flash('Importado !!');

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
                        if(isset($data['status']))
                            $data['status'] = \Lang::get('utils.status_client.'. $data['status']);

                         if(isset($data['debts']))
                            $data['debts'] = \Lang::get('utils.debts_client.'. $data['debts']);

                        if(isset($data['potencial']))
                            $data['potencial'] = \Lang::get('utils.potencial_client.'. $data['potencial']);

                    return $data;
                },$clients->toArray());
                
            
                $sheet->fromArray($data, null, 'A1', true);

            });


        })->export('xls');
    }


}
