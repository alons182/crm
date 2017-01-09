<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
           
                {!! Form::submit(isset($buttonText) ? $buttonText : 'Crear Banco',['class'=>'btn btn-primary'])!!}
                {!! link_to_route('banks',  'Cancelar', null, ['class'=>'btn btn-default'])!!}
                
        </header>
        <div class="panel-body">
            @if(isset($bank))
                {!! Form::hidden('bank_id',  $bank->id) !!}
            @endif

            <div class="form-group">
                {!! Form::label('name','Nombre:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('name',$errors) !!}
                </div>


            </div>
            
           

        </div>
    </section>
    
</div>
<div class="col-lg-6">

      @if (isset($bank))
    <section class="panel">
        <div class="panel-heading">
                @if(isset($bank))

                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                         {!! link_to_route('create_requirement_to_bank', 'Crear Requisito',  $bank->id, ['class'=>'btn btn-success'])!!}
                    @endif

                @endif
        </div>
    </section>
    <section class="panel panel-primary">

        <div class="panel-heading">Requisitos del banco
            
        </div>
        <div class="panel-group handles tasks no-margin" id="requirements">
            {!! Form::open(['route' =>['requirements_option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'Estas seguro?']) !!}
            @foreach ($bank->requirements as $requirement)
            <div class="panel">
                <div class="panel-heading">
                    <span>
                        <i class="fa fa-ellipsis-v text-muted mg-r-sm"></i>
                    </span>
                    <label class="checkbox checkbox-custom">
                        <input type="checkbox">
                        <i class="checkbox"></i>
                    </label>
                    <a data-toggle="collapse" data-parent="#requirements" href="#{!! $requirement->id !!}">
                        {!! $requirement->name !!}
                    </a>
                    <div class="task-toolbar  pull-right visible-lg visible-md">

                       
                
                            <a class="btn btn-info btn-xs" href="{!! URL::route('requirements.edit', [$requirement->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                               <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route('requirements.destroy', [$requirement->id]) !!}">
                                <i class="fa fa-trash-o"></i>
                                </button>
                            @endif
                    </div>
                </div>
                <div id="{!! $requirement->id !!}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p></p>
                        <div class=" pull-left mg-t-xs">
                            <small class="mg-r-sm">
                                <i>{!! $requirement->created_at !!}</i>
                            </small>
                            <a class="mg-r-sm" href="#">
                                
                                <small></small>
                            </a>
                            
                            
                            <a class="btn btn-info btn-xs" href="{!! URL::route('requirements.edit', [$requirement->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                <button type="submit" class="btn btn-danger btn-xs" form="form-delete" formaction="{!! URL::route('requirements.destroy', [$requirement->id]) !!}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            @endif
                            
                        </div>
                       
                    </div>
                </div>
            </div>
            @endforeach
            {!! Form::close() !!}
            
        </div>
    </section>
        {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'Estas seguro?']) !!} {!! Form::close() !!}
    @endif
    






</div>


		
		


