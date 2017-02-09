@extends('layouts.template')
@section('css')
    <!--<link rel="stylesheet" href="/vendor/bootstrap-datepicker/datepicker.css">-->
    <!-- <link rel="stylesheet" href="/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css"> -->
<style>
.table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    border: 1px solid #DDD;
}

/*.table-responsive .fixed-column {
    position: absolute;
    display: inline-block;
    width:9em;/*width: auto;*/
 /*   border-right: 1px solid #ddd;
    background-color: white;
    left: 0;
}
.table-responsive .fixed-column2 {
    position: absolute;
    display: inline-block;
    width:9em;/*width: auto;*/
   /* border-right: 1px solid #ddd;
    background-color: white;
    left: 9em;
}
.table-responsive .fixed-column3 {
    position: absolute;
    display: inline-block;
    width:9em;/*width: auto;*/
    /*border-right: 1px solid #ddd;
    background-color: white;
    left: 18em;
}
.table-responsive {
  overflow-x:scroll;  
  margin-left:2em;
    }

/*@media(min-width:768px) {
    .table-responsive>.fixed-column {
        display: none;
    }
}*/
    /*.table > thead:first-child > tr:first-child > th:first-child,
    .table > thead:nth-child(2) > tr:nth-child(2) > th:nth-child(2),
    .table > thead:nth-child(3) > tr:nth-child(3) > th:nth-child(3)
    {
        position: absolute;
        display: inline-block;
        background-color: red;
        height: 100%;
    }

    .table > tbody > tr > td:first-child,
    .table > tbody > tr > td:nth-child(2),
    .table > tbody > tr > td:nth-child(3)
     {
        position: absolute;
        display: inline-block;
        background-color: red;
        height: 100%;
    }

    .table > thead:first-child > tr:first-child > th:nth-child(2),
    .table > thead:first-child > tr:first-child > th:nth-child(3) {
        padding-left: 40px;
    }

    .table > tbody > tr > td:nth-child(2),
    .table > tbody > tr > td:nth-child(3) {
        padding-left: 50px !important;
    }*/
</style>
@stop
@section('content')
    @include('layouts/partials/_breadcumbs', ['page' => 'Reporte Ventas'])

    <section class="panel">

        <div class="panel-heading" style="overflow: hidden;">
        
            <div class="filtros" >
               
                {!! Form::open(['route' => 'r_sales','method' => 'get', 'class'=>'form-inline']) !!}
                            
                             <div class=" form-group">
                                
                                 {!! Form::select('currency', ['$' => '$','₡'=>'₡'] , $selectedCurrency, ['id'=>'currency','class'=>'form-control'] ) !!}
                             </div>
                             <div class=" form-group">
                                
                                 {!! Form::select('project', ['' => '-- Filtrar por proyecto --'] + $projects , $selectedProject, ['id'=>'project','class'=>'form-control'] ) !!}
                             </div>
                             <div class=" form-group">
                                
                                 {!! Form::select('month', ['' => '-- Filtrar por Mes --'] + $monthWithItems , $selectedMonth, ['id'=>'month','class'=>'form-control'] ) !!}
                             </div>
                             <div class=" form-group">
                                
                                 {!! Form::select('seller', ['' => '-- Filtrar por vendedor --'] + $sellers , $selectedSeller, ['id'=>'seller','class'=>'form-control'] ) !!}
                             </div>
                             
                {!! Form::close() !!}

            </div>
             <div class="export pull-right">
                <a href="#" class="btn btn-success" data-toggle="modal" data-target=".bs-modal-sm">Exportar</a>
                 
             </div>

            
        </div>
        <div class="panel-body no-padding">
            
           
            <div class="table-responsive">
                <table class="table table-bordered table-striped" /*data-toggle="table"*/>
                    <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th /*style="width: 5%"*/ >Casa</th>
                        <th /*style="width: 15%"*/>Cliente</th>
                        <th>Precio Venta</th>
                        <th>5%</th>
                        <th>Vendedor</th>
                        <th>% vendedor</th>
                        <th>Total vendedor</th>
                        <th>Vivenda</th>
                        <th>Entrega</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($clients as $client)
                        <tr>
                        
                            <td>{!! ($client->proyecto) ? $client->proyecto->name : '' !!}</td>
                            <td>{!!$client->properties->first()->name !!}</td>
                            <td>{!! $client->fullname !!}</td>
                            <td>{!! money($client->properties->first()->price, $client->properties->first()->currency ) !!}</td>
                            <td>{!! money($client->properties->first()->calculatePercent(), $client->properties->first()->currency)  !!} ({!! ($client->properties->first()->percent) ? $client->properties->first()->percent : '5' !!}%)</td>
                            <td>
                                @foreach($client->sellers as $seller)
                                    {!! $seller->name !!}
                                @endforeach
                            </td>
                            <td>{!! $client->properties->first()->seller_percent !!}%</td>
                            
                             
                            <td>{!! money($client->properties->first()->calculateSellerPercent(), $client->properties->first()->currency) !!}</td>
                            <td>{!! money($client->properties->first()->totalVivenda(), $client->properties->first()->currency)  !!}</td>
                           
                            
                            <td>{!! ($client->properties->first()->delivery_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->properties->first()->delivery_date)->toDateString()  !!}</td>

                            
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="success">
                            <td colspan="3"><center><b>Totales:</b></center></td>
                            
                            <td><b>{{ money($totalVenta, $selectedCurrency) }}</b></td>
                            <td><b>{{ money($totalPorc, $selectedCurrency) }}</b></td>
                            <td colspan="2"></td>
                            <td><b>{{ money($totalVendedor, $selectedCurrency) }}</b></td>
                            <td><b>{{ money($totalVivenda, $selectedCurrency) }}</b></td>
                            <td></td>
                        </tr>
                        
                    @if ($clients)
                        <tr>
                            <td  colspan="16" class="pagination-container">{!!$clients->appends(['project'=> $selectedProject,'month' => $selectedMonth,'currency' => $selectedCurrency, 'seller' => $selectedSeller])->render()!!}</td>
                        </tr>
                    @endif
                        
                       



                    </tfoot>
                </table>
            </div>
            
        </div>
    </section>

    <div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    {!! Form::open(['route' =>['export_sales'],'method' => 'post', 'id' =>'form-export']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5 class="modal-title text-center" id="myModalLabel">Exportar</h5>
                    </div>
                    <div class="modal-body">
                        
                        
                             <h3>Filtros</h3>
                             <div class="row">
                                <div class="col-xs-1">
                                    <div class=" form-group">
                                        
                                         {!! Form::select('fil-currency', ['$' => '$','₡'=>'₡'] , $selectedCurrency, ['id'=>'fil-currency','class'=>'form-control'] ) !!}
                                     </div>
                                </div>
                                <div class="col-xs-3">
                                     <div class=" form-group">
                                        
                                         {!! Form::select('fil-project', ['' => '-- Filtrar por proyecto --'] + $projects , $selectedProject, ['id'=>'fil-project','class'=>'form-control'] ) !!}
                                     </div>
                                </div>
                                 <div class="col-xs-3">
                                     <div class=" form-group">
                                        
                                         {!! Form::select('fil-month', ['' => '-- Filtrar por Mes --'] + $monthWithItems , $selectedMonth, ['id'=>'fil-month','class'=>'form-control'] ) !!}
                                     </div>
                                </div>
                                 <div class="col-xs-3">
                                     <div class=" form-group">
                                        
                                         {!! Form::select('fil-seller', ['' => '-- Filtrar por vendedor --'] + $sellers , $selectedSeller, ['id'=>'fil-seller','class'=>'form-control'] ) !!}
                                     </div>
                                </div>

                             </div>
                            
                       
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm">Exportar »</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    
@stop
@section('scripts')
<script>
    $(function(){
        /*var $table = $('.table');
        //Make a clone of our table
        var $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column');

        //Remove everything except for first column
        $fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();
       
        //Match the height of the rows to that of the original table's
        $fixedColumn.find('tr').each(function (i, elem) {
            $(this).height($table.find('tr:eq(' + i + ')').height());
        });*/
    });
</script>
<!-- <script src="/vendor/bootstrap.min.js"></script>   -->
<!-- Latest compiled and minified JavaScript -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script> -->
<!-- Latest compiled and minified Locales -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-zh-CN.min.js"> -->
@stop
