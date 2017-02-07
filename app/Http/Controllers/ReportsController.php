<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Project;
use App\Repositories\ClientRepo;
use App\Repositories\PropertyRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReportsController extends Controller
{
    function __construct(ClientRepo $clientRepo, PropertyRepo $propertyRepo) {
        $this->middleware('auth');
        
        $this->clientRepo = $clientRepo;
         $this->propertyRepo = $propertyRepo;
        
      
        View::share('projects', Project::where('status',1)->pluck('name','id')->all());

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tracing(Request $request)
    {
        $search = $request->all();
        $clients = [];
        
        if($search){

            $search['project'] = (isset($search['project'])) ? $search['project'] : '';
           
            
           
            $clients = $this->clientRepo->reports($search);
           // dd($clients->toArray());
            return View('reports.tracing')->with([
                'clients'         => $clients,
                'selectedProject' =>  $search['project']
                
            ]);
       }
        
        return View('reports.tracing')->with([
            'clients'         => $clients,
            'selectedProject' =>  ''
            
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales(Request $request)
    {
        $search = $request->all();
        $clients = [];
        
       

            $search['project'] = (isset($search['project'])) ? $search['project'] : '';
           
            
           
            $clients = $this->clientRepo->reportsSales($search);
           // dd($clients->toArray());
            return View('reports.sales')->with([
                'clients'         => $clients,
                'selectedProject' =>  $search['project']
                
            ]);
      
        
        
    }
}
