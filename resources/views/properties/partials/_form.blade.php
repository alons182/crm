<div class="col-lg-8">
    <section class="panel">
        <header class="panel-heading">
           
                {!! Form::submit(isset($buttonText) ? $buttonText : 'Crear Propiedad',['class'=>'btn btn-primary'])!!}
                
                <a href="/projects/{{ isset($property) ? $property->project_id : $project_id}}/edit" class="btn btn-default">Cancelar</a>
        </header>
        <div class="panel-body">
            @if(isset($property))
                {!! Form::hidden('property_id',  $property->id) !!}
                {!! Form::hidden('project_id',  $property->project_id) !!}
            @endif
            @if(isset($project_id))
                {!! Form::hidden('project_id',  $project_id) !!}
            @endif

            <div class="form-group">
                {!! Form::label('name','Nombre:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('name',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('price','Precio de venta:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                  
                    <div class="input-group mg-b-md">
                        <span class="input-group-addon">$</span>                                              
                        {!! Form::text('price', isset($property) ? money($property->price, false) : null,['class'=>'form-control','required'=>'required']) !!}
                        {!! errors_for('price',$errors) !!}

                        
                    </div> 

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('percent','Porcentaje:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <div class="input-group mg-b-md">
                        <span class="input-group-addon">%</span>  
                    {!! Form::text('percent', null,['class'=>'form-control']) !!}
                    {!! errors_for('percent',$errors) !!}
                    </div>
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('seller_percent','Porcentaje del Vendedor:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <div class="input-group mg-b-md">
                        <span class="input-group-addon">%</span> 
                    {!! Form::text('seller_percent', null,['class'=>'form-control']) !!}
                    {!! errors_for('seller_percent',$errors) !!}
                    </div>
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('office','Oficina:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('office', null,['class'=>'form-control']) !!}
                    {!! errors_for('office',$errors) !!}
                </div>


            </div>
            
            <div class="form-group">
                {!! Form::label('size','Tamaño de terreno M2:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('size', null,['class'=>'form-control']) !!}
                    {!! errors_for('size',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('construction','Tamaño de construcción M2:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('construction', null,['class'=>'form-control']) !!}
                    {!! errors_for('construction',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('rooms','Habitaciones:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('rooms', null,['class'=>'form-control']) !!}
                    {!! errors_for('rooms',$errors) !!}

                </div>


            </div>
            
            
            @if(isset($property))
               @if($property->status)
               <div class="form-group">
                    {!! Form::label('status','Estatus:',['class'=>'col-sm-2 control-label'])!!}
                   
                    <div class="col-sm-10">
                        @can('authorize_property')
                            {!! Form::select('status',['0' => 'Pendiente', '1' => 'Libre','2' => 'Vendida'], $property->status,['class'=>'form-control','required'=>'required'])!!}
                            {!! errors_for('status',$errors) !!}
                         @else
                            {!! Form::select('status',['1' => 'free','2' => 'Sold'], $property->status,['class'=>'form-control','required'=>'required'])!!}
                            {!! errors_for('status',$errors) !!}
                        @endcan
                    </div>
                  
                </div>
                @else 
                <div class="form-group">
                    {!! Form::label('status','Estatus:',['class'=>'col-sm-2 control-label'])!!}
                   
                    <div class="col-sm-10">
                     
                         @can('authorize_property')
                            {!! Form::select('status',['0' => 'Pendiente', '1' => 'Libre','2' => 'Vendida'], $property->status,['class'=>'form-control','required'=>'required'])!!}
                            {!! errors_for('status',$errors) !!}
                         @else
                            <a class="btn btn-danger btn-sm" href="#">
                            <i class="fa fa-user mg-r-xs"></i>
                                         Pendiente
                            </a>
                         @endcan
                    
                    </div>
                  
                </div>
                    
                @endif
            @endif
             @if(isset($property))
                @if($property->status)
                     <div class="form-group">
                        {!! Form::label('clients','Clientes:',['class'=>'col-sm-2 control-label'])!!}
                        <div class="col-sm-10">
                            <span class="btn btn-white btn-sm" data-toggle="modal" data-target=".bs-modal-sm" id="btn-add-user">Buscar</span>
                            <ul class="users">
                               

                                    @foreach($property->clients as $client)
                                    <li data-id="{!! $client->id !!}">
                                        <span class="delete" data-id="{!! $client->id !!}"><i class="glyphicon glyphicon-remove"></i></span>

                                        <span class="label label-success">{!! $client->fullname !!}</span>

                                        
                                        {!! Form::hidden('clients[]', $client->id , ['class' => 'form-control']) !!}
                                    </li>
                                    @endforeach
                                
                                   
                                
                                
                            </ul>
                           
                        </div>


                    </div>
                @endif
            @endif
            <div class="form-group">
                {!! Form::label('image','Imagen:',['class'=>'col-sm-2 control-label'])!!}

                <div class="col-sm-10">
                    {!! Form::file('image') !!}
                    {!! errors_for('image',$errors) !!}
                </div>
            </div>

           

        </div>
    </section>

</div>
<div class="col-lg-4">

    <section class="panel">
        <header class="panel-heading">
            {!! Form::label('image','Imagen Actual:',['class'=>'control-label'])!!}
        </header>
        <div class="panel-body">
            @if (isset($property))
                <div class="main_image">
                    @if ($property->image)
                        <img src="{!! photos_path('properties') !!}thumb_{!! $property->image !!}"
                             alt="{!! $property->image !!}">

                    @endif

                </div>
            @endif
                
        </div>

    </section>
    
      






    {!! Form::open(array('method' => 'post', 'id' => 'form-pend-comp')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'Estas Seguro?']) !!}{!! Form::close() !!}


</div>


		
		


