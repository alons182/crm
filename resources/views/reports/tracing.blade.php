@extends('layouts.template')
@section('css')
   <link rel="stylesheet" href="/vendor/classic.css">
    <link rel="stylesheet" href="/vendor/classic.date.css">
    <link rel="stylesheet" href="/vendor/classic.time.css">
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
                             <div class="form-group">
                                {!! Form::select('reservation_paid', ['' => '-- Filtrar si pagó reservación --'] + ['0' => 'No','1' => 'Si'] , $selectedReservationPaid, ['id'=>'reservation_paid','class'=>'form-control'] ) !!}
                                </div>
                             <div class=" form-group">
                                
                                 {!! Form::select('order', ['' => '-- Filtrar por fecha de ... --','reservation_date' => 'fecha de reserva','completed_house_date' =>'fecha de casa terminada', 'option_date' =>'fecha opcion firmada'] , $selectedOrder, ['id'=>'order','class'=>'form-control'] ) !!}
                             </div>

                                <div class="form-group ">
                            
                                     
                                        {!! Form::text('date1', $date1,['class'=>'form-control datepicker','placeholder'=>'Filtrar por fecha inicio']) !!}
                                       
                                </div>
                             
                                 
                                <div class="form-group ">
                                        {!! Form::text('date2', $date2,['class'=>'form-control datepicker','placeholder'=>'Filtrar por fecha fin']) !!}
                                        
                                    

                                </div>
                               
                             
                {!! Form::close() !!}

                 <div class="export pull-right">
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target=".bs-modal-sm">Exportar</a>
                     
                 </div>

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
                        <th colspan="5">Estados</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($clients as $client)
                        <tr>
                        
                            <td>{!! $client->casa !!}</td>
                            <td>{!! $client->bloque !!}</td>
                            <td>{!!$client->fullname!!}</td>
                            <td>{!! ($client->reservation_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->reservation_date)->toDateString()  !!}</td>
                            <td>{!! ($client->completed_house_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->completed_house_date)->toDateString()  !!}</td>
                            <td>{!! ($client->option_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->option_date)->toDateString()  !!}</td>
                            <td>{!! ($client->banco) ? $client->banco->name : 'Banco no asignado' !!}</td>
                            
                             
                            <td>{!! ($client->expedient_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->expedient_date)->toDateString()  !!}</td>
                            <td>{!! ($client->avaluo_date == '0000-00-00 00:00:00') ? '' : \Carbon\Carbon::parse($client->avaluo_date)->toDateString()  !!}</td>
                            <td>{!! ($client->fiador) ? 'Si' : 'No' !!}</td>
                            
                                @forelse($client->estados->take(5) as $comment)
                                  <td>
                                    <small class="label label-warning">{{ ($comment->user) ? $comment->user->name : '' }} - {{ $comment->created_at }}</small><br>
                                    {{ $comment->body }}
                                 </td>
                                @empty
                                  
                                @endforelse
                            

                            
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($clients)
                        <td  colspan="15" class="pagination-container">{!!$clients->appends(['project'=> $selectedProject, 'order'=> $selectedOrder])->render()!!}</td>
                    @endif


                    </tfoot>
                </table>
            </div>
            
        </div>
    </section>

      <div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    {!! Form::open(['route' =>['export_tracing'],'method' => 'post', 'id' =>'form-export']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5 class="modal-title text-center" id="myModalLabel">Exportar</h5>
                    </div>
                    <div class="modal-body">
                        
                        
                             <h3>Filtros</h3>
                             <div class="row">
                                <div class="col-xs-3">
                                     <div class=" form-group">
                                        
                                         {!! Form::select('fil-project', ['' => '-- Filtrar por proyecto --'] + $projects , $selectedProject, ['id'=>'fil-project','class'=>'form-control'] ) !!}
                                     </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                    {!! Form::select('fil-reservation_paid', ['' => '-- Filtrar si pagó reservación --'] + ['0' => 'No','1' => 'Si'] , $selectedReservationPaid, ['id'=>'fil-reservation_paid','class'=>'form-control'] ) !!}
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class=" form-group">
                                    
                                     {!! Form::select('fil-order', ['' => '-- Filtrar por fecha de ... --','reservation_date' => 'fecha de reserva','completed_house_date' =>'fecha de casa terminada', 'option_date' =>'fecha opcion firmada'] , $selectedOrder, ['id'=>'fil-order','class'=>'form-control'] ) !!}
                                     </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group ">
                                
                                         
                                            {!! Form::text('fil-date1', $date1,['class'=>'form-control datepicker','placeholder'=>'Filtrar por fecha inicio']) !!}
                                           
                                    </div>
                                </div>
                             
                                  <div class="col-xs-3">
                                    <div class="form-group ">
                                            {!! Form::text('fil-date2', $date2,['class'=>'form-control datepicker','placeholder'=>'Filtrar por fecha fin']) !!}
                                            
                                        

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
    <script src="/vendor/picker.js"></script>
    <script src="/vendor/picker.date.js"></script>
    <script src="/vendor/picker.time.js"></script>
    <!--
    <script src="/vendor/moment.js"></script>
        
    <script src="/vendor/bootstrap-datetimepicker.min.js"></script> -->
    <!--<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>-->
    <script type="text/javascript">
        /*$('.datepicker').datepicker();*/
        $('.datepicker').pickadate({
            monthsFull: ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
            monthsShort: ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'],
            weekdaysFull: ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'],
            weekdaysShort: ['dom', 'lun', 'mar', 'mié', 'jue', 'vie', 'sáb'],
            today: 'hoy',
            clear: 'borrar',
            close: 'cerrar',
            firstDay: 1,
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd',
            onClose: function(thingSet) {
                 var filters = $(".filtros");
                        
                   
                  filters.find('form').submit();
                    
              }
        });
        $('.fil-datepicker').pickadate({
            monthsFull: ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'],
            monthsShort: ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'],
            weekdaysFull: ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'],
            weekdaysShort: ['dom', 'lun', 'mar', 'mié', 'jue', 'vie', 'sáb'],
            today: 'hoy',
            clear: 'borrar',
            close: 'cerrar',
            firstDay: 1,
            format: 'yyyy-mm-dd',
            formatSubmit: 'yyyy-mm-dd'
            
        });
        
    </script>
@stop


