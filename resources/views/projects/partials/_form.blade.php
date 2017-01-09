<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
           
                {!! Form::submit(isset($buttonText) ? $buttonText : 'Crear Project',['class'=>'btn btn-primary'])!!}
                {!! link_to_route('projects',  'Cancelar', null, ['class'=>'btn btn-default'])!!}
                
        </header>
        <div class="panel-body">
            @if(isset($project))
                {!! Form::hidden('project_id',  $project->id) !!}
            @endif

            <div class="form-group">
                {!! Form::label('name','Nombre:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('name',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('province','Provincia:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::select('province', ['Guanacaste' => 'Guanacaste','San Jose' => 'San Jose','Alajuela' => 'Alajuela','Cartago' => 'Cartago','Heredia' => 'Heredia','Puntarenas' => 'Puntarenas','Limón' => 'Limón'], null,['class'=>'form-control'])!!}
                    {!! errors_for('province',$errors) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('address','Dirección:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('address', null,['class'=>'form-control']) !!}
                    {!! errors_for('address',$errors) !!}

                </div>


            </div>
            
            <div class="form-group">
                {!! Form::label('image','Imagen:',['class'=>'col-sm-2 control-label'])!!}

                <div class="col-sm-10">
                    {!! Form::file('image') !!}
                    {!! errors_for('image',$errors) !!}
                </div>
            </div>

           

        </div>
    </section>
      @if (isset($project))
    <section class="panel">
        <div class="panel-heading">
                @if(isset($project))

                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                         {!! link_to_route('create_property_to_project', 'Crear Propiedad o lote',  $project->id, ['class'=>'btn btn-success'])!!}
                    @endif

                @endif
        </div>
    </section>
    <section class="panel panel-primary">

        <div class="panel-heading">Propiedades o Lotes del proyecto 
            
        </div>
        <div class="panel-group handles tasks no-margin" id="properties">
            {!! Form::open(['route' =>['properties_option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'Estas seguro?']) !!}
            @foreach ($project->properties as $property)
            <div class="panel">
                <div class="panel-heading">
                    <span>
                        <i class="fa fa-ellipsis-v text-muted mg-r-sm"></i>
                    </span>
                    <label class="checkbox checkbox-custom">
                        <input type="checkbox">
                        <i class="checkbox"></i>
                    </label>
                    <a data-toggle="collapse" data-parent="#properties" href="#{!! $property->id !!}">
                        {!! $property->name !!} - 
                        @if ($property->status)
                                    @if($property->status == 1)
                                        <label class="label label-success">Libre</label>
                                     @elseif($property->status == 2)
                                        <label class="label label-warning">Vendido</label>
                                    @endif
                        @else
                            <label class="label label-danger">Pendiente</label>
                        @endif
                    </a>
                    <div class="task-toolbar  pull-right visible-lg visible-md">

                       
                       
                            @if ($property->status)
                                    @if($property->status == 1)
                                        <button type="submit"  class="btn btn-success btn-xs" form="form-free-sold" formaction="{!! URL::route('properties.sold', [$property->id]) !!}">Libre</button>
                                    @elseif($property->status == 2)
                                        <button type="submit"  class="btn btn-warning btn-xs" form="form-free-sold" formaction="{!! URL::route('properties.free', [$property->id]) !!}">Vendido</button>
                                   
                                    @endif

                                @else
                                    @can('authorize_property')
                                        <button type="submit"  class="btn btn-danger btn-xs  "form="form-free-sold" formaction="{!! URL::route('properties.free', [$property->id]) !!}" >Pendiente</button>
                                    @else 
                                        <a  class="btn btn-danger btn-xs"  href="#" >Pendiente</a>
                                    @endcan
                                @endif
                            <a class="btn btn-info btn-xs" href="{!! URL::route('properties.edit', [$property->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                               <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route('properties.destroy', [$property->id]) !!}">
                                <i class="fa fa-trash-o"></i>
                                </button>
                            @endif
                    </div>
                </div>
                <div id="{!! $property->id !!}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>
                            <i class="fa fa-money  mg-r-sm"></i>Precio: {!! money($property->price) !!}</p>
                        <div class=" pull-left mg-t-xs">
                            <small class="mg-r-sm">
                                <i>{!! $property->created_at !!}</i>
                            </small>
                            <a class="mg-r-sm" href="#">
                                
                                <small></small>
                            </a>
                            
                             @if ($property->status)
                                    @if($property->status == 1)
                                        <button type="submit"  class="btn btn-success btn-xs" form="form-free-sold" formaction="{!! URL::route('properties.sold', [$property->id]) !!}">Libre</button>
                                    @elseif($property->status == 2)
                                        <button type="submit"  class="btn btn-warning btn-xs" form="form-free-sold" formaction="{!! URL::route('properties.free', [$property->id]) !!}">Vendido</button>
                                   
                                    @endif

                                @else
                                    @can('authorize_property')
                                        <button type="submit"  class="btn btn-danger btn-xs  "form="form-free-sold" formaction="{!! URL::route('properties.free', [$property->id]) !!}" >Pendiente</button>
                                    @else 
                                        <a  class="btn btn-danger btn-xs"  href="#" >Pendiente</a>
                                    @endcan
                                @endif
                            <a class="btn btn-info btn-xs" href="{!! URL::route('properties.edit', [$property->id]) !!}">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                <button type="submit" class="btn btn-danger btn-xs" form="form-delete" formaction="{!! URL::route('properties.destroy', [$property->id]) !!}">
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
    @endif

</div>
<div class="col-lg-6">

    <section class="panel">
        <header class="panel-heading">
            {!! Form::label('image','Imagen Actual:',['class'=>'control-label'])!!}
        </header>
        <div class="panel-body">
            @if (isset($project))
                <div class="main_image">
                    @if ($project->image)
                        <img src="{!! photos_path('projects') !!}thumb_{!! $project->image !!}"
                             alt="{!! $project->image !!}">

                    @endif

                </div>
            @endif
                
        </div>

    </section>

   
    
      






   {!! Form::open(array('method' => 'post', 'id' => 'form-free-sold')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'Estas seguro?']) !!}{!! Form::close() !!}


</div>


		
		


