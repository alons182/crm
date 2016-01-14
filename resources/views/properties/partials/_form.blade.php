<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
           
                {!! Form::submit(isset($buttonText) ? $buttonText : 'Create Property',['class'=>'btn btn-primary'])!!}
                {!! link_to_route('properties',  'Cancel', null, ['class'=>'btn btn-default'])!!}
                
        </header>
        <div class="panel-body">
            @if(isset($property))
                {!! Form::hidden('property_id',  $property->id) !!}
            @endif

            <div class="form-group">
                {!! Form::label('name','Name:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('name',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('price','Price:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('price', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('price',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('province','Province:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::select('province', ['Guanacaste' => 'Guanacaste','San Jose' => 'San Jose','Alajuela' => 'Alajuela','Cartago' => 'Cartago','Heredia' => 'Heredia','Puntarenas' => 'Puntarenas','Limón' => 'Limón'], null,['class'=>'form-control','required'=>'required'])!!}
                    {!! errors_for('province',$errors) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('address','Address:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('address', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('address',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('size','Size:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('size', null,['class'=>'form-control']) !!}
                    {!! errors_for('size',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('rooms','Rooms:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('rooms', null,['class'=>'form-control']) !!}
                    {!! errors_for('rooms',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('owner','Owner:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('owner', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('owner',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('owner_phone1','Owner Phone 1:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('owner_phone1', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('owner_phone1',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('owner_phone2','Owner Phone 2:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('owner_phone2', null,['class'=>'form-control']) !!}
                    {!! errors_for('owner_phone2',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('owner_email','Owner Email:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::email('owner_email', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('owner_email',$errors) !!}

                </div>


            </div>
            <div class="form-group">
                {!! Form::label('project','Project:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('project', null,['class'=>'form-control']) !!}
                    {!! errors_for('project',$errors) !!}

                </div>


            </div>
            @if(isset($property))
               @if($property->status)
               <div class="form-group">
                    {!! Form::label('status','Status:',['class'=>'col-sm-2 control-label'])!!}
                   
                    <div class="col-sm-10">
                        @can('authorize_property')
                            {!! Form::select('status',['0' => 'Pending', '1' => 'free','2' => 'Sold'], $property->status,['class'=>'form-control','required'=>'required'])!!}
                            {!! errors_for('status',$errors) !!}
                         @else
                            {!! Form::select('status',['1' => 'free','2' => 'Sold'], $property->status,['class'=>'form-control','required'=>'required'])!!}
                            {!! errors_for('status',$errors) !!}
                        @endcan
                    </div>
                  
                </div>
                @else 
                <div class="form-group">
                    {!! Form::label('status','Status:',['class'=>'col-sm-2 control-label'])!!}
                   
                    <div class="col-sm-10">
                     
                         @can('authorize_property')
                            {!! Form::select('status',['0' => 'Pending', '1' => 'free','2' => 'Sold'], $property->status,['class'=>'form-control','required'=>'required'])!!}
                            {!! errors_for('status',$errors) !!}
                         @else
                            <a class="btn btn-danger btn-sm" href="#">
                            <i class="fa fa-user mg-r-xs"></i>
                                         Pending
                            </a>
                         @endcan
                    
                    </div>
                  
                </div>
                    
                @endif
            @endif
             @if(isset($property))
                @if($property->status)
                     <div class="form-group">
                        {!! Form::label('clients','Clients:',['class'=>'col-sm-2 control-label'])!!}
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
                {!! Form::label('image','Image:',['class'=>'col-sm-2 control-label'])!!}

                <div class="col-sm-10">
                    {!! Form::file('image') !!}
                    {!! errors_for('image',$errors) !!}
                </div>
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
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}


</div>


		
		


