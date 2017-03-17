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
    @include('layouts/partials/_breadcumbs', ['page' => 'Reporte Estadísticas de Vendedores'])

    <section class="panel">

        <div class="panel-heading" style="overflow: hidden;">
        
            <div class="filtros" >
               
                {!! Form::open(['route' => 'r_statistics_sellers','method' => 'get', 'class'=>'form-inline']) !!}
                            
                             <div class=" form-group">
                                
                                
                                   
                                    {!! Form::select('seller', ['' => '-- Filtrar por vendedor --'] + $sellers , $selectedSeller, ['id'=>'seller','class'=>'form-control'] ) !!}
                                   
                                
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
            
           
           <div class="row">
           @if($statistics)
                 <div class="col-md-3 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-default">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="no-margin">{{ $statistics['created'] }}</h3>
                                    Clientes Creados
                                </div>
                            </div>
                        </section>
                    </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-default">
                                    <i class="fa fa-edit"></i>
                                </div>
                                <div>
                                    <h3 class="no-margin">{{ $statistics['citas'] }}</h3>
                                    Citas
                                </div>
                            </div>
                        </section>
                    </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-purple">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="no-margin">{{ $statistics['reservados'] }}</h3>
                                    Clientes Reservados
                                </div>
                            </div>
                        </section>
                    </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-danger">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="no-margin">{{ $statistics['formalizados'] }}</h3>
                                    Clientes Formalizados
                                </div>
                            </div>
                        </section>
                    </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-success">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="no-margin">{{ $statistics['aprobados'] }}</h3>
                                    Clientes Aprobados
                                </div>
                            </div>
                        </section>
                    </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-warning">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="no-margin">{{ $statistics['interesados'] }}</h3>
                                    Clientes Interesados
                                </div>
                            </div>
                        </section>
                    </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-default">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="no-margin">{{ $statistics['retirados'] }}</h3>
                                    Clientes Retirados
                                </div>
                            </div>
                        </section>
                    </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                        <section class="panel">
                            <div class="panel-body">
                                <div class="circle-icon bg-info">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="no-margin">{{ $statistics['desinteresados'] }}</h3>
                                    Clientes Desinteresados
                                </div>
                            </div>
                        </section>
                    </div>
                
            @endif
                
            </div>
            
            
        </div>
    </section>

      <div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    {!! Form::open(['route' =>['export_statistics_sellers'],'method' => 'post', 'id' =>'form-export']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5 class="modal-title text-center" id="myModalLabel">Exportar</h5>
                    </div>
                    <div class="modal-body">
                        
                        
                             <h3>Filtros</h3>
                             <div class="row">
                                <div class="col-xs-3">
                                     <div class=" form-group">
                                        
                                        {!! Form::select('fil-seller', ['' => '-- Filtrar por vendedor --'] + $sellers , $selectedSeller, ['id'=>'fil-seller','class'=>'form-control'] ) !!}
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

