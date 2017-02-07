<div class="col-lg-8">
    <section class="panel">
        <header class="panel-heading">
                @if(isset($client))
                    @if(auth()->user()->isAsigned($client) || auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                        {!! Form::submit(isset($buttonText) ? $buttonText : 'Crear Cliente',['class'=>'btn btn-primary'])!!}
                    @endif
                @else
                    {!! Form::submit(isset($buttonText) ? $buttonText : 'Crear Cliente',['class'=>'btn btn-primary'])!!}
                @endif
                {!! link_to_route('clients',  'Cancelar', null, ['class'=>'btn btn-default'])!!}
                
        </header>
        <div class="panel-body">

            @if(isset($client))
                {!! Form::hidden('client_id',  $client->id) !!}
            @endif
            
            
            <div class="form-group">
                {!! Form::label('fullname','Nombre completo:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('fullname', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('fullname',$errors) !!}
                </div>


            </div>

            <div class="form-group">
                {!! Form::label('email','Email:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::email('email', null,['class'=>'form-control']) !!}
                    {!! errors_for('email',$errors) !!}

                </div>


            </div>

            <div class="form-group">
                {!! Form::label('phone1','Teléfono 1:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('phone1', null,['class'=>'form-control']) !!}
                    {!! errors_for('phone1',$errors) !!}

                </div>


            </div>

            <div class="form-group">
                {!! Form::label('referred','Referido:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                     <div class="row">
                        <div class="col-xs-3">
                            {!! Form::select('referred', ['mail' => 'Correo','facebook' => 'Facebook','website' => 'Sitio Web','vallas' => 'Vallas','others' => 'Otros'], null,['class'=>'form-control'])!!}
                            {!! errors_for('referred',$errors) !!}
                        </div>
                        <div class="col-xs-9">
                             {!! Form::text('referred_others',null,['class'=>'form-control','placeholder'=>'Otros', (isset($client)) ? ($client->referred != 'others') ? 'disabled' : '' : 'disabled']) !!}
                        </div>
                        
                    </div>



                </div>
            </div>
            @can('assign_sellers')
            <div class="form-group">
                {!! Form::label('Sellers','Vendedores:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    <span class="btn btn-white btn-sm" data-toggle="modal" data-target=".bs-modal-sm" id="btn-add-user">Buscar</span>
                    <ul class="users">
                        @if(isset($client))

                            @foreach($client->sellers as $seller)
                            <li data-id="{!! $seller->id !!}">
                                <span class="delete" data-id="{!! $seller->id !!}"><i class="glyphicon glyphicon-remove"></i></span>

                                <span class="label label-success">{!! $seller->name !!}</span>

                                
                                {!! Form::hidden('sellers[]', $seller->id , ['class' => 'form-control']) !!}
                            </li>
                            @endforeach
                        
                           
                        
                        @endif
                    </ul>
                    
                </div>
           </div>
           @else 
              {!! Form::hidden('sellers', $currentUser->id ) !!}
              
           @endcan

           <div class="form-group">
                    {!! Form::label('project','Proyecto:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-xs-3">
                                {!! Form::select('project', ['' => ''] + $projects, (isset($selectedProjects)) ? $selectedProjects: null,['class'=>'form-control '])!!}
                            {!! errors_for('project',$errors) !!}
                            </div>
                            <div class="col-xs-9">
                                 {!! Form::select('properties[]',(isset($propertiesOfSelectedProject)) ? $propertiesOfSelectedProject : $properties, (isset($selectedProperties)) ? $selectedProperties: null,['class'=>'form-control chosen-select','multiple', 'id'=>'selectProperties'])!!}
                                {!! errors_for('properties',$errors) !!}
                            </div>
                            
                        </div>


                    </div>
                </div>
           <div class="form-group">
                    {!! Form::label('status','Estatus:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                         {!! Form::select('status', ['0' => '','1' => 'Reservado','2' => 'Aprobado','3' => 'Interesado','4' => 'Formalizado'], null,['class'=>'form-control'])!!}
                            {!! errors_for('status',$errors) !!}
                    </div>
                </div>

             <div class="form-group">
                    {!! Form::label('potencial','Potencial:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                         {!! Form::select('potencial', ['0' => '','1' => 'Alto','2' => 'Medio','3' => 'Bajo'], null,['class'=>'form-control'])!!}
                            {!! errors_for('prima',$errors) !!}
                    </div>
                </div>





           
            
    </section>
    <section class="panel">
        <header class="panel-heading">
                <h2>Datos Complementarios</h2>
                
        </header>
        <div  style="padding: 15px;">
            <div class="form-group">
                {!! Form::label('address','Dirección Domiciliar:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::text('address',null,['class'=>'form-control']) !!}
                    {!! errors_for('address',$errors) !!}
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('ide','Cedula:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('ide', null,['class'=>'form-control','placeholder'=>'Ej: 101110111']) !!}
                    {!! errors_for('ide',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('income','Ingresos:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <div class="input-group mg-b-md">
                        <span class="input-group-addon">₡</span>                                              
                        {!! Form::text('income', isset($client) ? money($client->income, false) : null,['class'=>'form-control']) !!}
                        {!! errors_for('income',$errors) !!}

                        
                    </div> 

                     

                </div>


            </div>
            <div class="form-group">
                    {!! Form::label('prima','Prima:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::text('prima',null,['class'=>'form-control']) !!}
                        {!! errors_for('prima',$errors) !!}
                    </div>

                </div>   
            
            <div class="form-group">
                {!! Form::label('job','Lugar de Trabajo:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('job', null,['class'=>'form-control']) !!}
                    {!! errors_for('job',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('bank','Banco 1:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                     <div class="row">
                            <div class="col-xs-5">
                                {!! Form::select('bank', ['0' => ''] + $banks, null,['class'=>'form-control '])!!}
                            {!! errors_for('bank',$errors) !!}
                            </div>
                            <div class="col-xs-6">
                                 {!! Form::select('requirements[]',(isset($requirementsOfSelectedBank)) ? $requirementsOfSelectedBank : [], (isset($selectedRequirements)) ? $selectedRequirements : null,['class'=>'form-control chosen-select','multiple', 'id'=>'selectedRequirements'])!!}
                                {!! errors_for('requirements',$errors) !!}
                            </div>
                            
                        </div>
                     
                </div>
            </div>
             <div class="form-group">
                {!! Form::label('bank2','Banco 2:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                     <div class="row">
                            <div class="col-xs-5">
                                {!! Form::select('bank2', ['0' => ''] + $banks, null,['class'=>'form-control '])!!}
                            {!! errors_for('bank',$errors) !!}
                            </div>
                            <div class="col-xs-6">
                                 {!! Form::select('requirements2[]',(isset($requirementsOfSelectedBank2)) ? $requirementsOfSelectedBank2 : [], (isset($selectedRequirements)) ? $selectedRequirements : null,['class'=>'form-control chosen-select','multiple', 'id'=>'selectedRequirements2'])!!}
                                {!! errors_for('requirements2',$errors) !!}
                            </div>
                            
                        </div>
                     
                </div>
            </div>

                <div class="form-group">
                    {!! Form::label('comments','Estados:',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                          @if(isset($client))
                             {!! Form::textarea('comments', null,['class'=>'form-control', 'rows'=>'3','maxlength'=>'150']) !!}
                            {!! errors_for('comments',$errors) !!}
                            <a href="#" class="btn btn-xs btn-default" id="saveComment" data-client="{{ (isset($client)) ? $client->id : 0 }}">Guardar</a>
                            @else
                             <div class="alert alert-warning">
                                 Necesitas Guardar el cliente para poder agregarle estados
                             </div>
                           
                            @endif
                       
                        <section class="panel panel-dark" >
                            <div class="panel-heading">Estados
                                    <small class="pull-right">
                                        <a class="fa panel-collapsible pd-r-xs fa-chevron-down" href="#"></a>
                                        
                                    </small>
                                </div>
                            <!--<div class="panel-body bg-white">-->
                                <ul id="comments-list" class="list-group panel-body">
                                     @if(isset($client))
                                        @foreach($client->estados as $comment)
                                            <li  class="list-group-item">
                                                @can('edit_status_clients')
                                                 <a href="#" data-id="{{ $comment->id }}" class="btn btn-xs btn-danger pull-left btn-delete-comment" style="margin-right: 1rem;"><i class="fa fa-trash-o"></i></a>

                                                @endcan
                                                <small class="pull-right">{{ $comment->created_at }}</small>
                                                <div class="show no-margin pd-t-xs">
                                                    @can('edit_status_clients')
                                                        {!! Form::textarea('comments-item-'.$comment->id, $comment->body,['class'=>'form-control', 'rows'=>'3','maxlength'=>'150']) !!}
                                                       <a href="#" class="btn btn-xs btn-default updateComment" data-id="{{ $comment->id }}">Actualizar</a>
                                                    @else    
                                                        {{ $comment->body }}
                                                    @endcan
                                                    

                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                    
                                </ul>
                            <!--</div>-->
                            
                        </section>
                        
                    </div>
                    

                </div>
                
                <script id="commentsListTemplate" type="text/x-handlebars-template">
                    @{{#each this}}
                    <li data-id="@{{ id }}" class="list-group-item">
                         @can('edit_status_clients')
                            <a href="#" data-id="@{{ id }}" class="btn btn-xs btn-danger pull-left btn-delete-comment" style="margin-right: 1rem;"><i class="fa fa-trash-o"></i></a>
                         @endcan
                         <small class="pull-right">@{{ created_at }}</small>
                        <div class="show no-margin pd-t-xs">
                            @can('edit_status_clients')
                                <textarea name="comments-item-@{{ id }}" cols="30" rows="3" maxlength="150" class="form-control">@{{ body }}</textarea>
                                <a href="#" class="btn btn-xs btn-default updateComment" data-id="@{{ id }}">Actualizar</a>
                            @else    
                                @{{ body }}
                            @endcan
                            
                            
                        </div>
                       
                    </li>
                    @{{/each}}


                </script>

                <div class="form-group">
                    {!! Form::label('reservation_date','Fecha firma de reserva:',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        
                            
                        <input type="text" class="form-control datepicker" name="reservation_date" value="{{ isset($client) && ($client->reservation_date != '0000-00-00 00:00:00') ? $client->reservation_date : '' }}">
                        
                        {!! errors_for('reservation_date',$errors) !!}
                    </div>
                    
                            
                       
                </div>
                <div class="form-group">
                    {!! Form::label('option_date','Fecha firma de opción:',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        
                            
                        <input type="text" class="form-control datepicker" name="option_date" value="{{ isset($client) && ($client->option_date != '0000-00-00 00:00:00') ? $client->option_date : '' }}">
                        
                        {!! errors_for('option_date',$errors) !!}
                    </div>
                    
                            
                       
                </div>
                 <div class="form-group">
                    {!! Form::label('expedient_date','Fecha presentacion de expediente:',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        
                            
                        <input type="text" class="form-control datepicker" name="expedient_date" value="{{ isset($client) && ($client->expedient_date != '0000-00-00 00:00:00') ? $client->expedient_date : '' }}">
                        
                        {!! errors_for('expedient_date',$errors) !!}
                    </div>
                    
                            
                       
                </div>
                <div class="form-group">
                    {!! Form::label('avaluo_date','Fecha de avaluo:',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        
                            
                        <input type="text" class="form-control datepicker" name="avaluo_date" value="{{ isset($client) && ($client->avaluo_date != '0000-00-00 00:00:00') ? $client->avaluo_date : '' }}">
                        
                        {!! errors_for('avaluo_date',$errors) !!}
                    </div>
                    
                            
                       
                </div>
          
               <div class="form-group">
                    {!! Form::label('formalization_date','Fecha de formalización:',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        
                            
                        <input type="text" class="form-control datepicker" name="formalization_date" value="{{ isset($client) && ($client->formalization_date != '0000-00-00 00:00:00') ? $client->formalization_date : '' }}">
                        
                        {!! errors_for('formalization_date',$errors) !!}
                    </div>
                    
                            
                       
                </div>
                
                
                
                <div class="form-group">
                    {!! Form::label('documents','Documentos:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                          <div class="row">
                            <div class="col-xs-2">
                                {!! Form::select('documents', ['1' => 'Si','0' => 'No'], null,['class'=>'form-control'])!!}
                                {!! errors_for('documents',$errors) !!}
                            </div>
                            <div class="col-xs-10">
                                {!! Form::textarea('documents_text', null,['class'=>'form-control','rows'=>'2', (isset($client)) ? ($client->documents != '0') ? 'disabled' : '' : 'disabled']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('fiador','Fiador:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                            <div class="row">
                                <div class="col-xs-2">
                                    {!! Form::select('fiador', ['0' => 'No','1' => 'Si'], null,['class'=>'form-control'])!!}
                                    {!! errors_for('fiador',$errors) !!}
                                </div>
                                <div class="col-xs-10">
                                    {!! Form::textarea('fiador_text', null,['class'=>'form-control','rows'=>'2', (isset($client)) ? ($client->fiador != '1') ? 'disabled' : '' : 'disabled']) !!}
                                </div>
                            </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('credit','Linea de credito:',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                       
                        {!! Form::text('credit', null,['class'=>'form-control']) !!}
                        {!! errors_for('credit',$errors) !!}

                    </div>


                </div>

                
                <!-- <div class="form-group">
                    {!! Form::label('image','Imagen:',['class'=>'col-sm-2 control-label'])!!}

                    <div class="col-sm-10">
                        {!! Form::file('image') !!}
                        {!! errors_for('image',$errors) !!}
                    </div>
                </div> -->
                <div class="form-group">

                    {!! Form::label('file','Archivos Adjuntos:',['class'=>'control-label col-sm-2'])!!}
                    <div class="col-sm-10">
                    @if(isset($client))

                        <div id="container-files">

                            <a class="UploadButton btn btn-info" id="UploadButton">Subir Archivo</a>
                            <div id="InfoBox"></div>
                            <ul id="files-list">

                                @foreach ($client->files as $file)
                                    <li>
                                        <span class="delete" data-file="{!! $file->id !!}" title="Eliminar Archivo"><i class="icon-close fa fa-trash-o"></i></span>
                                        <a href="{!! photos_path('clients') !!}{!! $file->client_id !!}/files/{!! $file->name !!}" title="{!! $file->name !!}" target="_blank">{!! $file->name !!}</a>
                                    </li>
                                @endforeach

                            </ul>
                            <script id="fileTemplate" type="text/x-handlebars-template">

                                <li>
                                    <span class="delete" data-file="@{{ id }}" title="Eliminar archivo"><i class="icon-close fa fa-trash-o"></i></span>
                                    <a href="/media/clients/@{{ client_id }}/files/@{{ name }}" title="@{{ name }}" target="_blank">@{{ name }}</a>
                                </li>


                            </script>

                        </div>
                    @else
                        <div id="inputs_files">
                            <input class="inputbox btn btn-info" type="button" name="new_file"  value="Nuevo Archivo"  id="add_input_file"/><i class="glyphicon glyphicon-plus-sign"></i>

                            <!--<input class="inputfile" id="imageGallery" type="file" name="new_photo_file[]" data-multiple-caption="{count} imagenes seleccionadas" multiple  />
                            <label for="imageGallery"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Agregar imagenes</span></label>
                            <output id="result" />-->
                        </div>

                    @endif
                    </div>
                </div>
            

            </div>
            
          

                
             
        
    </section>

</div>
<div class="col-lg-4">

    <section class="panel">
        <header class="panel-heading">
            {!! Form::label('image','Imagen actual:',['class'=>'control-label'])!!}
        </header>
        <div class="panel-body">
            @if (isset($client))
                <div class="main_image">
                    @if ($client->image)
                        <img src="{!! photos_path('clients') !!}thumb_{!! $client->image !!}"
                             alt="{!! $client->image !!}">

                    @endif

                </div>
            @endif
                
        </div>

    </section>
    @if (isset($client))
    <section class="panel">
        <div class="panel-heading">
                @if(isset($client))

                    @if(auth()->user()->isAsigned($client) || auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                       {!! link_to_route('create_task_to_client', 'Crear Tarea o Notificación',  $client->id, ['class'=>'btn btn-success'])!!}
                    @endif

                @endif
        </div>
    </section>
    <section class="panel panel-primary">

        <div class="panel-heading">TAREAS 
            
        </div>
        <div class="panel-group handles tasks no-margin" id="tasks">
            {!! Form::open(['route' =>['tasks_option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'Estas seguro?']) !!}
            @foreach ($client->tasks as $task)
            <div class="panel">
                <div class="panel-heading">
                    <span>
                        <i class="fa fa-ellipsis-v text-muted mg-r-sm"></i>
                    </span>
                    <label class="checkbox checkbox-custom">
                        <input type="checkbox">
                        <i class="checkbox"></i>
                    </label>
                    <a data-toggle="collapse" data-parent="#tasks" href="#{!! $task->id !!}">
                        {!! $task->title !!}
                    </a>
                    <div class="task-toolbar  pull-right visible-lg visible-md">

                       
                       
                            @if(auth()->user()->isAsigned($client) || auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                @if ($task->status)
                                    <button type="submit"  class="btn btn-success btn-xs" form="form-pend-comp" formaction="{!! URL::route('tasks.pend', [$task->id]) !!}" ><i class="fa fa-star"></i> Completada</button>
                                @else
                                   
                                    <button type="submit"  class="btn btn-warning btn-xs" form="form-pend-comp" formaction="{!! URL::route('tasks.comp', [$task->id]) !!}"><i class="fa fa-star-o"></i> Pendiente</button>
                                @endif
                            @else
                                @if ($task->status)
                                    <div  class="btn btn-success btn-xs"><i class="fa fa-star"></i> Completada</div>
                                @else
                                    <div class="btn btn-warning btn-xs"><i class="fa fa-star-o"></i> Pendiente</div>
                                @endif
                            @endif
                            <a class="btn btn-info btn-xs" href="{!! URL::route('tasks.edit', [$task->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(auth()->user()->isAsigned($client) || auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                              @can('delete_tasks')
                                    <button type="submit" class="btn btn-danger btn-xs" form="form-delete" formaction="{!! URL::route('tasks.destroy', [$task->id]) !!}">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                @endcan
                            @endif
                    </div>
                </div>
                <div id="{!! $task->id !!}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>
                            <i class="fa fa-folder-o  mg-r-sm"></i> {!! $task->description !!}</p>
                        <div class=" pull-left mg-t-xs">
                            <small class="mg-r-sm">
                                <i>{!! $task->created_at !!}</i>
                            </small>
                            <a class="mg-r-sm" href="#">
                                
                                <small>{!! $client->fullname  !!}</small>
                            </a>
                            
                             @if ($task->status)
                                <button type="submit"  class="btn btn-success btn-xs" form="form-pend-comp" formaction="{!! URL::route('tasks.pend', [$task->id]) !!}" ><i class="fa fa-star"></i> Completada</button>
                            @else
                               
                                <button type="submit"  class="btn btn-warning btn-xs" form="form-pend-comp" formaction="{!! URL::route('tasks.comp', [$task->id]) !!}"><i class="fa fa-star-o"></i> Pendiente</button>
                            @endif
                            <a class="btn btn-info btn-xs" href="{!! URL::route('tasks.edit', [$task->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            @can('delete_tasks')
                                <button type="submit" class="btn btn-danger btn-xs" form="form-delete" formaction="{!! URL::route('tasks.destroy', [$task->id]) !!}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            @endcan
                            
                        </div>
                        <a href="#" class="btn btn-default btn-xs pull-right text-muted">
                            <small>
                                <i class="fa fa-share mg-r-xs"></i>Notificación</small>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
            {!! Form::close() !!}
            
        </div>
    </section>
    @endif
      






    {!! Form::open(array('method' => 'post', 'id' => 'form-pend-comp')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'Estas seguro?']) !!}{!! Form::close() !!}


</div>


		
		


