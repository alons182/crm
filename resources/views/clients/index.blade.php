@extends('layouts.template')
@section('css')
    <!--<link rel="stylesheet" href="/vendor/bootstrap-datepicker/datepicker.css">-->
    <link rel="stylesheet" href="/vendor/classic.css">
    <link rel="stylesheet" href="/vendor/classic.date.css">
    <link rel="stylesheet" href="/vendor/classic.time.css">

@stop
@section('content')
    @include('layouts/partials/_breadcumbs', ['page' => 'Clientes'])

    <section class="panel">

        <div class="panel-heading" style="position: relative;">
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                <div class="import pull-right" style="position: absolute;right: 0;top: 0">
                     <h4>Importar Excel (CVS, XLS)</h4>
                     {!! Form::open(['route' =>['import_clients'],'method' => 'post','files'=> true, 'id' =>'form-import']) !!}
                        {!! Form::file('excel', null, ['id' => 'excel', 'required'=>'required']) !!}
                        {!! errors_for('excel',$errors) !!} 
                        {!! Form::submit('Import',['class'=>'btn btn-primary'])!!}

                        <a href="#" class="btn btn-success" data-toggle="modal" data-target=".bs-modal-sm">Exportar</a>
                    {!! Form::close() !!}
                     
                </div>
            @endif
            <div class=" form-group">
                {!! link_to_route('clients.create','Nuevo Cliente',null,['class'=>'btn btn-success']) !!}
            </div>
            @include('clients/partials/_search')
            
        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'Estas seguro?']) !!}
             @can('delete_clients')
            <button type="submit" class="btn-multiple btn btn-danger btn-sm " data-action="delete" title="Delete"><i class="fa fa-trash-o"></i></button>
            @endcan
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{!! Form::checkbox('select_all', 0, null, ['id' => 'select-all']) !!}
                            {!! Form::hidden('select_action', null, ['id' => 'select-action']) !!} 
                         </th>
                        <th>#</th>
                        <th>IDE</th>
                        <th>Nombre completo</th>
                        <th>Vendedor</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Estatus</th>
                        <th>Ultimo Estado</th>
                        <th>Creado</th>

                        
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($clients as $client)
                        <tr class="bg-{!! \Lang::get('utils.status_color.'. $client->status)  !!}">
                            <td>{!! Form::checkbox('chk_client[]', $client->id, null, ['class' => 'chk-item']) !!}</td>
                            <td>{!!$client->id!!}</td>
                             <td>{!! $client->ide !!}</td>
                            <td>{!!$client->fullname!!}</td>
                            <td>
                                @foreach($client->sellers as $seller)
                                     {!! $seller->name !!}
                                @endforeach
                            </td>
                             <td>{!! $client->email !!}</td>
                              <td>{!! $client->phone1 !!}</td>
                             <td><span class="btn btn-{!! \Lang::get('utils.status_color.'. $client->status)  !!} btn-sm">
                                         
                                         {!! \Lang::get('utils.status_client.'. $client->status)  !!}
                                </span></td>
                            
                              <!-- <td>
                               @foreach($client->sellers as $seller)
                                    @can('edit_sellers')
                                       <a class="btn btn-info btn-sm" href="{!! URL::route('sellers.edit', [$seller->id]) !!}">
                                         <i class="fa fa-user mg-r-xs"></i>
                                         {!! $seller->name !!}
                                        </a>
                                    @else
                                        <span class="btn btn-info btn-sm">
                                         <i class="fa fa-user mg-r-xs"></i>
                                         {!! $seller->name !!}
                                        </span>
                                    @endcan
                                @endforeach
                               </td>-->
                            <td class="center">{!! ($client->estados->first()) ? ($client->estados->first()->user) ? '('.$client->estados->first()->user->name .') '.$client->estados->first()->body : $client->estados->first()->body : '' !!}</td>
                            <td class="center">{!! $client->created_at !!}</td>

                            <td class="center" style="background-color: white;">
                               
                                <a class="btn btn-info" href="{!! URL::route('clients.edit', [$client->id]) !!}">
                                <i class="fa fa-edit"></i>
                                </a>
                              
                                @if(auth()->user()->isAsigned($client) || auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                    @can('delete_clients')
                                    <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route('clients.destroy', [$client->id]) !!}">
                                    <i class="fa fa-trash-o"></i>
                                    </button>
                                     @endcan
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($clients)
                        <td  colspan="10" class="pagination-container">{!!$clients->appends(['q' => $search,'referred'=> $selectedReference,'seller'=> $selectedSeller, 'status'=> $selectedStatus,'project'=> $selectedProject,'potencial'=> $selectedPotencial, 'date1' => $date1,'date2' =>$date2, 'cita' => $selectedCita ])->render()!!}</td>
                    @endif


                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </section>

    <div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    {!! Form::open(['route' =>['export_clients'],'method' => 'post', 'id' =>'form-export']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5 class="modal-title text-center" id="myModalLabel">Exportar</h5>
                    </div>
                    <div class="modal-body">
                        
                        
                             <h3>Filtros</h3>
                            <div class="row">
                                <div class="col-xs-4">
                                    {!! Form::text('fil-q',null, ['class'=>'form-control','placeholder'=>'Buscar'] ) !!}
                                </div>
                                <div class='col-xs-4'>
                                    {!! Form::select('fil-referred', ['' => '-- Filtrar por referencia --','mail' => 'Correo','facebook' => 'Facebook','website' => 'Sitio Web','vallas' => 'Vallas','others' => 'Otros'], null, ['id'=>'fil-referred','class'=>'form-control'] ) !!}
                                </div>
                                <div class='col-xs-4'>
                                    {!! Form::select('fil-seller', ['' => '-- Filtrar por vendedor --'] + $sellers , null, ['id'=>'fil-seller','class'=>'form-control'] ) !!}
                                </div>
                                

                            </div>
                            <div class="row">
                                <div class='col-xs-4'>
                                    {!! Form::select('fil-status', ['' => '-- Filtrar por estatus --'] + ['1' => 'En Tramite','2' => 'Aprobado','3' => 'Interesado','4' => 'Denegado'] , null, ['id'=>'fil-status','class'=>'form-control'] ) !!}
                                </div>
                                <div class=" col-xs-4">

                                    {!! Form::select('fil-debts', ['' => '-- Filtrar por deudas --'] + ['1' => 'No Deudas','2' => 'Si Deudas','3' => 'Por Consultar','4' => 'Monto especifico'] , null, ['id'=>'fil-debts','class'=>'form-control'] ) !!}

                                 </div>
                                 <div class=" col-xs-4">

                                    {!! Form::select('fil-potencial', ['' => '-- Filtrar por potencial --'] + ['1' => 'Alto','2' => 'Medio','3' => 'Bajo'] , null, ['id'=>'fil-potencial','class'=>'form-control'] ) !!}

                                 </div>
                                <div class='col-xs-4'>
                                   {!! Form::text('fil-date1', null,['class'=>'form-control fil-datepicker','placeholder'=>'Filtrar por fecha']) !!}
                                    {!! errors_for('fil-date1',$errors) !!}
                                    
                                </div>
                                <div class="col-xs-4">
                                    {!! Form::text('fil-date2', null,['class'=>'form-control fil-datepicker','placeholder'=>'Filtrar por fecha']) !!}
                                    {!! errors_for('fil-date2',$errors) !!}
                                </div>
                                <div class="col-xs-4">
                                
                                     {!! Form::select('fil-project', ['' => '-- Filtrar por proyecto --'] + $projects , null, ['id'=>'fil-project','class'=>'form-control'] ) !!}


                                 </div>
                            </div>
                            <div class="row">
                                <h3>Campos a exportar</h3>
                                @foreach ($fieldsToExport as $field)
                                <div class='col-xs-4'>
                                    <label>
                                            <input type="checkbox" name="exp-{{ $field }}" value="{{ $field}}" >
                                            {{  \Lang::get('utils.export_fields.'.$field) }}</label>
                                </div>
                                @endforeach
                                
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






    {!! Form::open(array('method' => 'post', 'id' => 'form-pub-unpub')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'post', 'id' => 'form-feat-unfeat']) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'Estas seguro?']) !!}{!! Form::close() !!}
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
