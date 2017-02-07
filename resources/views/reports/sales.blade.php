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
                                
                                 {!! Form::select('project', ['' => '-- Filtrar por proyecto --'] + $projects , $selectedProject, ['id'=>'project','class'=>'form-control'] ) !!}
                             </div>
                             
                {!! Form::close() !!}

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
                        <th>Porcentaje vendedor</th>
                        <th>Total vendedor</th>
                        <th>Vivenda</th>
                        <th>₡ vivenda</th>
                        <th>Entrega</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($clients as $client)
                        <tr>
                        
                            <td>{!! ($client->proyecto) ? $client->proyecto->name : '' !!}</td>
                            <td>{!!$client->properties->first()->name !!}</td>
                            <td>{!! $client->fullname !!}</td>
                            <td>{!! money($client->properties->first()->price) !!}</td>
                            <td>{!! money($client->properties->first()->calculatePercent())  !!} ({!! ($client->properties->first()->percent) ? $client->properties->first()->percent : '5' !!}%)</td>
                            <td>
                                @foreach($client->sellers as $seller)
                                    {!! $seller->name !!}
                                @endforeach
                            </td>
                            <td>{!! $client->properties->first()->seller_percent !!}%</td>
                            
                             
                            <td>{!! money($client->properties->first()->calculateSellerPercent()) !!}</td>
                            <td>{!! money($client->properties->first()->totalVivenda())  !!}</td>
                            <td>{!! convertColon($client->properties->first()->totalVivenda())  !!}</td>
                            
                            <td>{!! ($client->properties->first()->delivery_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->properties->first()->delivery_date)->toDateString()  !!}</td>

                            
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($clients)
                        <td  colspan="16" class="pagination-container">{!!$clients->appends(['project'=> $selectedProject])->render()!!}</td>
                    @endif


                    </tfoot>
                </table>
            </div>
            
        </div>
    </section>

    
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
