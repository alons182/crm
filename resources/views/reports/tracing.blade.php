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
    @include('layouts/partials/_breadcumbs', ['page' => 'Reporte Seguimiento'])

    <section class="panel">

        <div class="panel-heading" style="overflow: hidden;">
        
            <div class="filtros" >
               
                {!! Form::open(['route' => 'r_tracing','method' => 'get', 'class'=>'form-inline']) !!}
                            
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
                        <th /*style="width: 5%"*/ >Casa</th>
                        <th>Bloque</th>
                        <th /*style="width: 15%"*/>Cliente</th>
                        <th>Fecha Reserva</th>
                        <th>Fecha Casa terminada</th>
                        <th>Opción firmada</th>
                        <th>Banco</th>
                        <th>Presentacion expediente</th>
                        <th>Fecha de Avalúo</th>
                        <th>Fiador / codeudor</th>
                        <th colspan="6">Estados</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($clients as $client)
                        <tr>
                        
                            <td>{!!$client->properties()->first()->name!!}</td>
                            <td>{!! $client->properties()->first()->block !!}</td>
                            <td>{!!$client->fullname!!}</td>
                            <td>{!! ($client->reservation_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->reservation_date)->toDateString()  !!}</td>
                            <td>{!! ($client->properties()->first()->completed_house_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->properties()->first()->completed_house_date)->toDateString()  !!}</td>
                            <td>{!! ($client->option_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->option_date)->toDateString()  !!}</td>
                            <td>{!! $client->getBankName() !!}</td>
                            
                             
                            <td>{!! ($client->expedient_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->expedient_date)->toDateString()  !!}</td>
                            <td>{!! ($client->avaluo_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->avaluo_date)->toDateString()  !!}</td>
                            <td>{!! ($client->fiador) ? 'Si' : 'No' !!}</td>
                            
                                @forelse($client->comments()->get() as $comment)
                                  <td>
                                    <small class="label label-warning">{{ $comment->created_at }}</small><br>
                                    {{ $comment->body }}
                                 </td>
                                @empty
                                  <td>
                                    
                                  </td>
                                @endforelse
                            

                            
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
