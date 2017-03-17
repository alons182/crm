<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests;
use App\Project;
use App\Property;
use App\Repositories\ClientRepo;
use App\Repositories\PropertyRepo;
use App\Repositories\SellerRepo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Excel;

class ReportsController extends Controller
{
    function __construct(SellerRepo $sellerRepo, ClientRepo $clientRepo, PropertyRepo $propertyRepo) {
        $this->middleware('auth');

        $this->sellerRepo = $sellerRepo;
        $this->clientRepo = $clientRepo;
         $this->propertyRepo = $propertyRepo;
        
      
        View::share('projects', Project::where('status',1)->pluck('name','id')->all());
       
        //View::share('monthWithItems', $this->getSelectMonthWithYearFoSalesProjection());
        View::share('sellers', User::pluck('name','id')->all());
       
    }
    protected function getSelectMonthWithYearFoSalesProjection()
    {
        $monthWithItems = [];

        $items = Property::selectRaw('year(delivery_date) year, month(delivery_date) month, monthname(delivery_date) monthname, count(*) items')
                         ->groupBy('year','month')
                         ->orderByRaw('min(delivery_date) DESC')
                         ->get()
                         ->toArray();
       
        foreach ($items as $month) {
            
            if($month['year'] > 0)
                $monthWithItems[$month['month'] .'_'. $month['year']] = $month['monthname'] .' '. $month['year'];
        }
        
        return $monthWithItems;
    }

    protected function getSelectMonthWithYearFoSales()
    {
        $monthWithItems = [];

        $items = Client::selectRaw('year(reservation_date) year, month(reservation_date) month, monthname(reservation_date) monthname, count(*) items')
                         ->groupBy('year','month')
                         ->orderByRaw('min(reservation_date) DESC')
                         ->get()
                         ->toArray();
       
        foreach ($items as $month) {
            
            if($month['year'] > 0)
                $monthWithItems[$month['month'] .'_'. $month['year']] = $month['monthname'] .' '. $month['year'];
        }
        
        return $monthWithItems;
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
            $search['reservation_paid'] = (isset($search['reservation_paid'])) ? $search['reservation_paid'] : '';
            $search['order'] = (isset($search['order'])) ? $search['order'] : '';
            $search['date1'] = (isset($search['date1'])) ? $search['date1'] : '';
            $search['date2'] = (isset($search['date2'])) ? $search['date2'] : '';

           
            
           
            $clients = $this->clientRepo->reportsTracing($search);
           // dd($clients->toArray());
            return View('reports.tracing')->with([
                'clients'         => $clients,
                'selectedProject' =>  $search['project'],
                'selectedOrder' =>  $search['order'],
                'selectedReservationPaid' => $search['reservation_paid'],
                'date1' => $search['date1'],
                'date2' => $search['date2']
            ]);
       }
        
        return View('reports.tracing')->with([
            'clients'         => $clients,
            'selectedProject' =>  '',
            'selectedOrder' =>'',
            'selectedReservationPaid' =>'',
            'date1' => '',
            'date2' => ''
        ]);
    }
     public function exportTracing(Excel $excel, Request $request)
    {
        $data = $request->all();

       /* $fields = array_where($data, function ($key, $value) {
            return starts_with($key,'exp-');
        });*/
        $filters = array_where($data, function ($key, $value) {
            return starts_with($key,'fil-');
        });


        \Excel::create('Tracing', function ($excel) use ($filters)
        {

            $excel->sheet('Seguimiento', function ($sheet) use ($filters)
            {
                $data = [];

                $clients = $this->clientRepo->reportsTracingExcel($filters);

               

                foreach ($clients as $client) {
                 
                    $itemArray = [];
                    
                    $itemArray['Lote / Casa'] = $client->casa;
                    $itemArray['Bloque'] = $client->bloque;
                    $itemArray['Cliente'] = $client->fullname;
                    $itemArray['Fecha de reserva'] = ($client->reservation_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->reservation_date)->toDateString();
                    $itemArray['Fecha de casa terminada'] = ($client->completed_house_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->completed_house_date)->toDateString();
                    $itemArray['Fecha opcion firmada'] = ($client->option_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->option_date)->toDateString();
                    $itemArray['Banco'] = ($client->banco) ? $client->banco->name : 'Banco no asignado';
                    $itemArray['Fecha Presentacion de expediente'] = ($client->expedient_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->expedient_date)->toDateString();
                    $itemArray['Fecha de Evaluo'] = ($client->avaluo_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->avaluo_date)->toDateString();
                    $itemArray['Fiador'] = ($client->fiador) ? 'Si' : 'No';

                     foreach($client->estados as $comment)
                     {
                       $username = '';
                       if($comment->user)
                       {
                            $username = $comment->user->name;
                       }
                        $itemArray['('.$comment->id.'-'. $username .')'.$comment->created_at->toDateString()] = $comment->body;
                           
                     }

                    $data[] = $itemArray;
                }
                   
                            
                
            
                $sheet->fromArray($data, null, 'A1', true);

            });


        })->export('xls');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales(Request $request)
    {
        $monthWithItems = $this->getSelectMonthWithYearFoSales();
        $search = $request->all();
        $clients = [];
        $totalVenta = 0;
        $totalPorc = 0;
        $totalVivenda = 0;
        $totalVendedor = 0;

            $search['project'] = (isset($search['project'])) ? $search['project'] : '';
            $search['currency'] = (isset($search['currency'])) ? $search['currency'] : '₡';
            $search['seller'] = (isset($search['seller'])) ? $search['seller'] : '';
            $search['selectedMonth'] = (isset($search['month'])) ? $search['month'] : '';
            $search['month'] = '';
            $search['year'] = '';
            $search['reservation_paid'] = (isset($search['reservation_paid'])) ? $search['reservation_paid'] : '';

            if(isset($search['selectedMonth']) && $search['selectedMonth'] != ''){
                $porciones = explode("_", $search['selectedMonth']);
                $search['month'] = $porciones[0];
                $search['year'] = $porciones[1];
            }

           
            $clients = $this->clientRepo->reportsSales($search);

            foreach ($clients->get() as $client) {
                $totalVenta += $client->properties->first()->price;
                $totalPorc += $client->properties->first()->calculatePercent();
                $totalVendedor += $client->properties->first()->calculateSellerPercent();
                $totalVivenda += $client->properties->first()->totalVivenda();
            }

            $clients = $clients->paginate(10);
            
            //dd($totalVenta);
            return View('reports.sales')->with([
                'clients'         => $clients,
                'selectedProject' =>  $search['project'],
                'selectedCurrency' =>  $search['currency'],
                'selectedMonth' =>  $search['selectedMonth'],
                'selectedSeller' =>  $search['seller'],
                'selectedReservationPaid' =>  $search['reservation_paid'],
                /*'monthWithItems' => ['1_2017'=>'Enero', '2_2017'=>'febrero'],*/
                'totalVenta' => $totalVenta,
                'totalPorc' => $totalPorc,
                'totalVendedor' => $totalVendedor,
                'totalVivenda' => $totalVivenda,
                'monthWithItems' => $monthWithItems,
                

                
            ]);
      
        
        
    }

     public function exportSales(Excel $excel, Request $request)
    {
        $data = $request->all();

       /* $fields = array_where($data, function ($key, $value) {
            return starts_with($key,'exp-');
        });*/
        $filters = array_where($data, function ($key, $value) {
            return starts_with($key,'fil-');
        });


        \Excel::create('Sales', function ($excel) use ($filters)
        {

            $excel->sheet('Ventas', function ($sheet) use ($filters)
            {
                $totalVenta = 0;
                $totalPorc = 0;
                $totalVivenda = 0;
                $totalVendedor = 0;
                $data = [];

               $filters['fil-selectedMonth'] = (isset($filters['fil-month'])) ? $filters['fil-month'] : '';
               $filters['fil-month'] = '';
               $filters['fil-year'] = '';

                if(isset($filters['fil-selectedMonth']) && $filters['fil-selectedMonth'] != ''){
                    $porciones = explode("_", $filters['fil-selectedMonth']);
                    $filters['fil-month'] = $porciones[0];
                    $filters['fil-year'] = $porciones[1];
                }

                //dd($this->clientRepo->reportClients($fields, $filters)->toArray());
                $clientsRaw = $this->clientRepo->reportsSalesExcel($filters);
               

                foreach ($clients = $clientsRaw->get() as $client) {
                    $totalVenta += $client->properties->first()->price;
                    $totalPorc += $client->properties->first()->calculatePercent();
                    $totalVendedor += $client->properties->first()->calculateSellerPercent();
                    $totalVivenda += $client->properties->first()->totalVivenda();

                    $itemArray['Proyecto'] = ($client->proyecto) ? $client->proyecto->name : '';
                    $itemArray['Lote / Casa'] = $client->properties->first()->name;
                    $itemArray['Cliente'] = $client->fullname;
                    $itemArray['Precio '.$filters['fil-currency']] = $client->properties->first()->price;
                    $itemArray['5%'] = $client->properties->first()->calculatePercent();
                    $itemArray['Vendedor'] = implode(", ", $client->sellers->pluck('name')->all());
                    $itemArray['% Vendedor'] = $client->properties->first()->seller_percent;
                    $itemArray['Total Vendedor'] = $client->properties->first()->calculateSellerPercent();
                    $itemArray['Total Vivenda'] = $client->properties->first()->totalVivenda();
                    $itemArray['Fecha de reserva'] = ($client->reservation_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->reservation_date)->toDateString();
                    
                    $data[] = $itemArray;
                }
                    /*** linea totales ***/
                    $itemArray['Proyecto'] = '';
                    $itemArray['Lote / Casa'] = '';
                    $itemArray['Cliente'] = '';
                    $itemArray['Precio '.$filters['fil-currency']] = '';
                    $itemArray['5%'] = '';
                    $itemArray['Vendedor'] = '';
                    $itemArray['% Vendedor'] = '';
                    $itemArray['Total Vendedor'] = '';
                    $itemArray['Total Vivenda'] = '';
                    $itemArray['Fecha de reserva'] = '';

                    $data[] = $itemArray;
                    
                    $itemArray['Proyecto'] = 'Totales';
                    $itemArray['Lote / Casa'] = '';
                    $itemArray['Cliente'] = '';
                    $itemArray['Precio '.$filters['fil-currency']] = $totalVenta;
                    $itemArray['5%'] = $totalPorc;
                    $itemArray['Vendedor'] = '';
                    $itemArray['% Vendedor'] = '';
                    $itemArray['Total Vendedor'] = $totalVendedor;
                    $itemArray['Total Vivenda'] = $totalVivenda;
                    $itemArray['Fecha de reserva'] = '';

                    $data[] = $itemArray;

                
            
                $sheet->fromArray($data, null, 'A1', true);

            });


        })->export('xls');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_projection(Request $request)
    {
        $monthWithItems = $this->getSelectMonthWithYearFoSalesProjection();

        $search = $request->all();
        $clients = [];
        $totalVenta = 0;
        $totalPorc = 0;
        $totalVivenda = 0;
        $totalVendedor = 0;

            $search['project'] = (isset($search['project'])) ? $search['project'] : '';
            $search['currency'] = (isset($search['currency'])) ? $search['currency'] : '₡';
            $search['seller'] = (isset($search['seller'])) ? $search['seller'] : '';
            $search['selectedMonth'] = (isset($search['month'])) ? $search['month'] : '';
            $search['month'] = '';
            $search['year'] = '';
            $search['reservation_paid'] = (isset($search['reservation_paid'])) ? $search['reservation_paid'] : '';

            if(isset($search['selectedMonth']) && $search['selectedMonth'] != ''){
                $porciones = explode("_", $search['selectedMonth']);
                $search['month'] = $porciones[0];
                $search['year'] = $porciones[1];
            }

           
            $clients = $this->clientRepo->reportsSalesProjection($search);

            foreach ($clients->get() as $client) {
                $totalVenta += $client->properties->first()->price;
                $totalPorc += $client->properties->first()->calculatePercent();
                $totalVendedor += $client->properties->first()->calculateSellerPercent();
                $totalVivenda += $client->properties->first()->totalVivenda();
            }

            $clients = $clients->paginate(10);
            
            //dd($totalVenta);
            return View('reports.sales_projection')->with([
                'clients'         => $clients,
                'selectedProject' =>  $search['project'],
                'selectedCurrency' =>  $search['currency'],
                'selectedMonth' =>  $search['selectedMonth'],
                'selectedSeller' =>  $search['seller'],
                'selectedReservationPaid' =>  $search['reservation_paid'],
                /*'monthWithItems' => ['1_2017'=>'Enero', '2_2017'=>'febrero'],*/
                'totalVenta' => $totalVenta,
                'totalPorc' => $totalPorc,
                'totalVendedor' => $totalVendedor,
                'totalVivenda' => $totalVivenda,
                'monthWithItems' => $monthWithItems,

                
            ]);
      
        
        
    }

     public function exportSalesProjection(Excel $excel, Request $request)
    {
        $data = $request->all();

       /* $fields = array_where($data, function ($key, $value) {
            return starts_with($key,'exp-');
        });*/
        $filters = array_where($data, function ($key, $value) {
            return starts_with($key,'fil-');
        });


        \Excel::create('Sales_projection', function ($excel) use ($filters)
        {

            $excel->sheet('Proyeccion de Ventas', function ($sheet) use ($filters)
            {
                $totalVenta = 0;
                $totalPorc = 0;
                $totalVivenda = 0;
                $totalVendedor = 0;
                $data = [];

               $filters['fil-selectedMonth'] = (isset($filters['fil-month'])) ? $filters['fil-month'] : '';
               $filters['fil-month'] = '';
               $filters['fil-year'] = '';

                if(isset($filters['fil-selectedMonth']) && $filters['fil-selectedMonth'] != ''){
                    $porciones = explode("_", $filters['fil-selectedMonth']);
                    $filters['fil-month'] = $porciones[0];
                    $filters['fil-year'] = $porciones[1];
                }

                //dd($this->clientRepo->reportClients($fields, $filters)->toArray());
                $clientsRaw = $this->clientRepo->reportsSalesProjectionExcel($filters);
               

                foreach ($clients = $clientsRaw->get() as $client) {
                    $totalVenta += $client->properties->first()->price;
                    $totalPorc += $client->properties->first()->calculatePercent();
                    $totalVendedor += $client->properties->first()->calculateSellerPercent();
                    $totalVivenda += $client->properties->first()->totalVivenda();

                    $itemArray['Proyecto'] = ($client->proyecto) ? $client->proyecto->name : '';
                    $itemArray['Lote / Casa'] = $client->properties->first()->name;
                    $itemArray['Cliente'] = $client->fullname;
                    $itemArray['Precio '.$filters['fil-currency']] = $client->properties->first()->price;
                    $itemArray['5%'] = $client->properties->first()->calculatePercent();
                    $itemArray['Vendedor'] = implode(", ", $client->sellers->pluck('name')->all());
                    $itemArray['% Vendedor'] = $client->properties->first()->seller_percent;
                    $itemArray['Total Vendedor'] = $client->properties->first()->calculateSellerPercent();
                    $itemArray['Total Vivenda'] = $client->properties->first()->totalVivenda();
                    $itemArray['Fecha de entrega'] = ($client->properties->first()->delivery_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->properties->first()->delivery_date)->toDateString();
                    
                    $data[] = $itemArray;
                }
                    /*** linea totales ***/
                    $itemArray['Proyecto'] = '';
                    $itemArray['Lote / Casa'] = '';
                    $itemArray['Cliente'] = '';
                    $itemArray['Precio '.$filters['fil-currency']] = '';
                    $itemArray['5%'] = '';
                    $itemArray['Vendedor'] = '';
                    $itemArray['% Vendedor'] = '';
                    $itemArray['Total Vendedor'] = '';
                    $itemArray['Total Vivenda'] = '';
                    $itemArray['Fecha de entrega'] = '';

                    $data[] = $itemArray;
                    
                    $itemArray['Proyecto'] = 'Totales';
                    $itemArray['Lote / Casa'] = '';
                    $itemArray['Cliente'] = '';
                    $itemArray['Precio '.$filters['fil-currency']] = $totalVenta;
                    $itemArray['5%'] = $totalPorc;
                    $itemArray['Vendedor'] = '';
                    $itemArray['% Vendedor'] = '';
                    $itemArray['Total Vendedor'] = $totalVendedor;
                    $itemArray['Total Vivenda'] = $totalVivenda;
                    $itemArray['Fecha de entrega'] = '';

                    $data[] = $itemArray;

                
                
                $sheet->fromArray($data, null, 'A1', true);

            });


        })->export('xls');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statistics_clients(Request $request)
    {
        $search = $request->all();
        $statistics = [];
        
        if($search){

            $search['project'] = (isset($search['project'])) ? $search['project'] : '';
            $search['date1'] = (isset($search['date1'])) ? $search['date1'] : '';
            $search['date2'] = (isset($search['date2'])) ? $search['date2'] : '';

           
            
           
            $statistics = $this->clientRepo->reportsStatisticsClients($search);
           // dd($clients->toArray());
            return View('reports.statistics_clients')->with([
                'statistics'         => $statistics,
                'selectedProject' =>  $search['project'],
                'date1' =>  $search['date1'],
                'date2' => $search['date2']
            ]);
       }
        
        return View('reports.statistics_clients')->with([
            'statistics'         => $statistics,
            'selectedProject' =>  '',
            'date1' =>'',
            'date2' =>''
        ]);
    }
     public function exportStatisticsClients(Excel $excel, Request $request)
    {
        $data = $request->all();

       /* $fields = array_where($data, function ($key, $value) {
            return starts_with($key,'exp-');
        });*/
        $filters = array_where($data, function ($key, $value) {
            return starts_with($key,'fil-');
        });


        \Excel::create('Statistics-Clients', function ($excel) use ($filters)
        {

            $excel->sheet('Estadisticas de Clientes', function ($sheet) use ($filters)
            {
                $data = [];

                $statistics = $this->clientRepo->reportsStatisticsClientsExcel($filters);

               
                //dd($statistics);
                foreach ($statistics as $statistic) {
                 
                    //$itemArray = [];

                    if($statistic['status'] != 0){

                        $itemArray['Estado'] = \Lang::get('utils.status_client.'. $statistic['status']);
                        $itemArray['Cantidad'] = $statistic['items'];

                        $data[] = $itemArray;
                    }
                }
                   
                            
              
            
                $sheet->fromArray($data, null, 'A1', true);

            });


        })->export('xls');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statistics_sellers(Request $request)
    {
        $search = $request->all();
        $statistics = [];
        
        if($search && $search['seller']){

            $search['seller'] = (isset($search['seller'])) ? $search['seller'] : '';
            $search['date1'] = (isset($search['date1'])) ? $search['date1'] : '';
            $search['date2'] = (isset($search['date2'])) ? $search['date2'] : '';

           
            
           
            $statistics = $this->sellerRepo->reportsStatisticsSellers($search);
           // dd($clients->toArray());
            return View('reports.statistics_sellers')->with([
                'statistics'         => $statistics,
                'selectedSeller' =>  $search['seller'],
                'date1' =>  $search['date1'],
                'date2' => $search['date2']
            ]);
       }
        
        return View('reports.statistics_sellers')->with([
            'statistics'         => $statistics,
            'selectedSeller' =>  '',
            'date1' =>'',
            'date2' =>''
        ]);
    }

    public function exportStatisticsSellers(Excel $excel, Request $request)
    {
        $data = $request->all();

       /* $fields = array_where($data, function ($key, $value) {
            return starts_with($key,'exp-');
        });*/
        $filters = array_where($data, function ($key, $value) {
            return starts_with($key,'fil-');
        });


        \Excel::create('Statistics-Sellers', function ($excel) use ($filters)
        {

            $excel->sheet('Estadisticas de Vendedores', function ($sheet) use ($filters)
            {
                $data = [];

                $statistics = $this->sellerRepo->reportsStatisticsSellersExcel($filters);

               
                //dd($statistics);
                $itemArray['Clientes Creados'] = $statistics['created'];
                $itemArray['Citas'] = $statistics['citas'];
                $itemArray['Reservados'] = $statistics['reservados'];
                $itemArray['Formalizados'] = $statistics['formalizados'];
                $itemArray['Aprobados'] = $statistics['aprobados'];
                $itemArray['Interesados'] = $statistics['interesados'];
                $itemArray['Retirados'] = $statistics['retirados'];
                $itemArray['Desinteresados'] = $statistics['desinteresados'];
                

                $data[] = $itemArray;

                /*foreach ($statistics as $statistic) {
                 
                    //$itemArray = [];

                    

                        $itemArray['Estado'] = \Lang::get('utils.status_client.'. $statistic['status']);
                        $itemArray['Cantidad'] = $statistic['items'];

                        $data[] = $itemArray;
                    
                }*/
                   
                            
              
            
                $sheet->fromArray($data, null, 'A1', true);

            });


        })->export('xls');
    }
}
