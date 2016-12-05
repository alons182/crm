<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
                @if(isset($client))
                    @if(auth()->user()->isAsigned($client) || auth()->user()->hasRole('admin'))
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
                {!! Form::label('ide','IDE:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('ide', null,['class'=>'form-control','placeholder'=>'Ej: 101110111']) !!}
                    {!! errors_for('ide',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('fullname','Nombre completo:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('fullname', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('fullname',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('company','Compañia:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('company', null,['class'=>'form-control']) !!}
                    {!! errors_for('company',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('job','Trabajo:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('job', null,['class'=>'form-control']) !!}
                    {!! errors_for('job',$errors) !!}

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
                {!! Form::label('income','Ingresos:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <div class="input-group mg-b-md">
                        <span class="input-group-addon">₡</span>                                              
                        {!! Form::text('income', isset($client) ? money($client->income, false) : null,['class'=>'form-control','required'=>'required']) !!}
                        {!! errors_for('income',$errors) !!}

                        
                    </div> 

                     

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
                {!! Form::label('phone2','Teléfono 2:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('phone2', null,['class'=>'form-control']) !!}
                    {!! errors_for('phone2',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('comments','Comentarios:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::textarea('comments', null,['class'=>'form-control']) !!}
                    {!! errors_for('comments',$errors) !!}

                </div>


            </div>
          
            <div class="form-group">
                {!! Form::label('address','Dirección:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::text('address',null,['class'=>'form-control']) !!}
                    {!! errors_for('address',$errors) !!}
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
                    {!! Form::label('properties','Propiedades:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::select('properties[]',$properties, (isset($selectedProperties)) ? $selectedProperties: null,['class'=>'form-control chosen-select','multiple'])!!}
                        {!! errors_for('properties',$errors) !!}
                    </div>
                </div>
           <div class="form-group">
                    {!! Form::label('status','Estatus:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                         {!! Form::select('status', ['0' => '','1' => 'Finalizado','2' => 'Pre-Aprobado','3' => 'Interesado','4' => 'Denegado'], null,['class'=>'form-control'])!!}
                            {!! errors_for('status',$errors) !!}
                    </div>
                </div>
            <div class="form-group">
                    {!! Form::label('debts','Deudas:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                         <div class="row">
                            <div class="col-xs-3">
                                {!! Form::select('debts', ['0' => '','1' => 'No Deudas','2' => 'Si Deudas','3' => 'Por Consultar','4' => 'Monto Especifico'], null,['class'=>'form-control'])!!}
                                {!! errors_for('debts',$errors) !!}
                            </div>
                            <div class="col-xs-9">
                                <div class="input-group mg-b-md">
                                    <span class="input-group-addon">₡</span>   
                                 {!! Form::text('debts_amount', isset($client) ? money($client->debts_amount, false) : null,['class'=>'form-control','placeholder'=>'Monto Especifico', (isset($client)) ? ($client->debts != '4') ? 'disabled' : '' : 'disabled']) !!}
                                 </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="form-group">
                {!! Form::label('prima','Prima Disponible:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::text('prima',null,['class'=>'form-control']) !!}
                    {!! errors_for('prima',$errors) !!}
                </div>

            </div>
             <div class="form-group">
                    {!! Form::label('potencial','Potencial:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                         {!! Form::select('potencial', ['0' => '','1' => 'Alto','2' => 'Medio','3' => 'Bajo'], null,['class'=>'form-control'])!!}
                            {!! errors_for('prima',$errors) !!}
                    </div>
                </div>   
             <div class="form-group">
                {!! Form::label('image','Imagen:',['class'=>'col-sm-2 control-label'])!!}

                <div class="col-sm-10">
                    {!! Form::file('image') !!}
                    {!! errors_for('image',$errors) !!}
                </div>
            </div>

           
            
    </section>

</div>
<div class="col-lg-6">

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

                    @if(auth()->user()->isAsigned($client) || auth()->user()->hasRole('admin'))
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

                       
                       
                            @if(auth()->user()->isAsigned($client) || auth()->user()->hasRole('admin'))
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
                            @if(auth()->user()->isAsigned($client) || auth()->user()->hasRole('admin'))
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


		
		


