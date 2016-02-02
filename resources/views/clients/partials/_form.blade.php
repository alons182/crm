<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
           
                {!! Form::submit(isset($buttonText) ? $buttonText : 'Create Client',['class'=>'btn btn-primary'])!!}
                {!! link_to_route('clients',  'Cancel', null, ['class'=>'btn btn-default'])!!}
                
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
                {!! Form::label('fullname','Full Name:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('fullname', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('fullname',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('company','Company:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('company', null,['class'=>'form-control']) !!}
                    {!! errors_for('company',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('job','Job:',['class'=>'col-sm-2 control-label']) !!}
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
                {!! Form::label('web','Website:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('web', null,['class'=>'form-control']) !!}
                    {!! errors_for('web',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('phone1','Phone 1:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('phone1', null,['class'=>'form-control']) !!}
                    {!! errors_for('phone1',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('phone2','Phone 2:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('phone2', null,['class'=>'form-control']) !!}
                    {!! errors_for('phone2',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('phone3','Phone 3:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('phone3', null,['class'=>'form-control']) !!}
                    {!! errors_for('phone3',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('phone4','Phone 4:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('phone4', null,['class'=>'form-control']) !!}
                    {!! errors_for('phone4',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('address','Address:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::text('address',null,['class'=>'form-control']) !!}
                    {!! errors_for('address',$errors) !!}
                </div>

            </div>
            <div class="form-group">
                {!! Form::label('referred','Referred:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                     <div class="row">
                        <div class="col-xs-3">
                            {!! Form::select('referred', ['mail' => 'Mail','facebook' => 'Facebook','website' => 'Website','vallas' => 'Vallas','others' => 'Others'], null,['class'=>'form-control'])!!}
                            {!! errors_for('referred',$errors) !!}
                        </div>
                        <div class="col-xs-9">
                             {!! Form::text('referred_others',null,['class'=>'form-control','placeholder'=>'Others', (isset($client)) ? ($client->referred != 'others') ? 'disabled' : '' : 'disabled']) !!}
                        </div>
                        
                    </div>



                </div>
            </div>
            @can('assign_sellers')
            <div class="form-group">
                {!! Form::label('Sellers','Sellers:',['class'=>'col-sm-2 control-label'])!!}
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
                    {!! Form::label('properties','Properties:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::select('properties[]',$properties, (isset($selectedProperties)) ? $selectedProperties: null,['class'=>'form-control chosen-select','multiple'])!!}
                        {!! errors_for('properties',$errors) !!}
                    </div>
                </div>
           
             <div class="form-group">
                {!! Form::label('image','Image:',['class'=>'col-sm-2 control-label'])!!}

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
            {!! Form::label('image','Current Image:',['class'=>'control-label'])!!}
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
                    {!! link_to_route('create_task_to_client', 'Create Task',  $client->id, ['class'=>'btn btn-success'])!!}
                @endif
        </div>
    </section>
    <section class="panel panel-primary">

        <div class="panel-heading">TASKS 
            
        </div>
        <div class="panel-group handles tasks no-margin" id="tasks">
            {!! Form::open(['route' =>['tasks_option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'You are sure?']) !!}
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

                       
                       
                            @if ($task->status)
                                <button type="submit"  class="btn btn-success btn-xs" form="form-pend-comp" formaction="{!! URL::route('tasks.pend', [$task->id]) !!}" ><i class="fa fa-star"></i> Complete</button>
                            @else
                               
                                <button type="submit"  class="btn btn-warning btn-xs" form="form-pend-comp" formaction="{!! URL::route('tasks.comp', [$task->id]) !!}"><i class="fa fa-star-o"></i> Pending</button>
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
                                <button type="submit"  class="btn btn-success btn-xs" form="form-pend-comp" formaction="{!! URL::route('tasks.pend', [$task->id]) !!}" ><i class="fa fa-star"></i> Complete</button>
                            @else
                               
                                <button type="submit"  class="btn btn-warning btn-xs" form="form-pend-comp" formaction="{!! URL::route('tasks.comp', [$task->id]) !!}"><i class="fa fa-star-o"></i> Pending</button>
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
                                <i class="fa fa-share mg-r-xs"></i>Notification</small>
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
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}


</div>


		
		


