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
    @include('layouts/partials/_breadcumbs', ['page' => 'Reporte Estadísticas de clientes'])

    <section class="panel">

        <div class="panel-heading" style="overflow: hidden;">
        
            <div class="filtros" >
               
                {!! Form::open(['route' => 'r_statistics_clients','method' => 'get', 'class'=>'form-inline']) !!}
                            
                             <div class=" form-group">
                                
                                 {!! Form::select('project', ['' => '-- Filtrar por proyecto --'] + $projects , $selectedProject, ['id'=>'project','class'=>'form-control'] ) !!}
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
             <h2>Clientes:</h2>
           
           <div class="row">
          
                @foreach($statistics as $statistic)
                    @if($statistic['status'] != 0)
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <section class="panel">
                                <div class="panel-body">
                                    <div class="circle-icon bg-{!! \Lang::get('utils.status_color.'. $statistic['status']) !!} ">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div>
                                        <h3 class="no-margin">{{ $statistic['items'] }}</h3>
                                         {!! \Lang::get('utils.status_client.'. $statistic['status'])  !!}
                                    </div>
                                </div>
                            </section>
                        </div>
                    @endif
                @endforeach
                
            </div>
            
            
        </div>
    </section>

      <div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    {!! Form::open(['route' =>['export_statistics_clients'],'method' => 'post', 'id' =>'form-export']) !!}
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
                               <div class='col-xs-4'>
                                   {!! Form::text('fil-date1', null,['class'=>'form-control fil-datepicker','placeholder'=>'Filtrar por fecha']) !!}
                                   
                                    
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::text('fil-date2', null,['class'=>'form-control fil-datepicker','placeholder'=>'Filtrar por fecha']) !!}
                                    
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

