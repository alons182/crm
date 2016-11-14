<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
                    {!! Form::submit(isset($buttonText) ? $buttonText : 'Crear Vendedor',['class'=>'btn btn-primary'])!!}
                    {!! link_to_route('sellers',  'Cancelar' , null, ['class'=>'btn btn-default'])!!}
         </header>
        <div class="panel-body">



                <div class="form-group">
                    {!! Form::label('name','Usuario:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::text('name',null,['class'=>'form-control','required'=>'required'])!!}
                        {!! errors_for('name',$errors) !!}
                    </div>


                </div>
                <div class="form-group">
                    {!! Form::label('email','Email:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::email('email',null,['class'=>'form-control','required'=>'required'])!!}
                        {!! errors_for('email',$errors) !!}
                    </div>

                </div>

                <div class="form-group">
                    {!! Form::label('password','Contraseña:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                         {!! Form::password('password',['class'=>'form-control'])!!}
                         {!! errors_for('password',$errors) !!}
                    </div>


                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation','Confirmación de Contraseña:',['class'=>'col-sm-2 control-label'])!!}
                     <div class="col-sm-10">
                        {!! Form::password('password_confirmation',['class'=>'form-control'])!!}
                      </div>
                </div>

                <div class="form-group">
                    {!! Form::label('role','Tipo:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::select('role[]',$roles, (isset($seller))? $selectedRoles : null,['class'=>'form-control', 'multiple'])!!}
                        {!! errors_for('role',$errors) !!}
                    </div>
                </div>

                <div class="form-group">
                {!! Form::label('clients','Clientes:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    <span class="btn btn-white btn-sm" data-toggle="modal" data-target=".bs-modal-sm" id="btn-add-user">Buscar</span>
                    <ul class="users">
                        @if(isset($seller))

                            @foreach($seller->clients as $client)
                            <li data-id="{!! $client->id !!}">
                                <span class="delete" data-id="{!! $client->id !!}"><i class="glyphicon glyphicon-remove"></i></span>

                                <span class="label label-success">{!! $client->fullname !!}</span>

                                
                                {!! Form::hidden('clients[]', $client->id , ['class' => 'form-control']) !!}
                            </li>
                            @endforeach
                        
                           
                        
                        @endif
                    </ul>
                   
                </div>


            </div>


        </div>
    </section>
		
</div>
<div class="col-lg-6">

    <section class="panel">
        <header class="panel-heading">
            Perfil
        </header>
        <div class="panel-body">
               <div class="form-group">
                    {!! Form::label('fullname','Nombre Completo:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::text('fullname',(isset($seller)) ? $seller->profile->fullname : null,['class'=>'form-control','required'=>'required'])!!}
                        {!! errors_for('fullname',$errors) !!}
                    </div>

                </div>
                <div class="form-group">
                    {!! Form::label('address','Dirección:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::textarea('address',(isset($seller)) ? $seller->profile->address : null,['class'=>'form-control'])!!}
                        {!! errors_for('address',$errors) !!}
                    </div>

                </div>
                <div class="form-group">
                    {!! Form::label('phone1','Teléfono 1:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::text('phone1',(isset($seller)) ? $seller->profile->phone1 : null,['class'=>'form-control','required'=>'required'])!!}
                        {!! errors_for('phone1',$errors) !!}
                    </div>

                </div>
                <div class="form-group">
                    {!! Form::label('phone2','Teléfono 2:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::text('phone2',(isset($seller)) ? $seller->profile->phone2 : null,['class'=>'form-control'])!!}
                        {!! errors_for('phone2',$errors) !!}
                    </div>

                </div>
                 <div class="form-group">
                    {!! Form::label('image','Imagen:',['class'=>'col-sm-2 control-label'])!!}

                    <div class="col-sm-10">
                        {!! Form::file('image') !!}
                        {!! errors_for('image',$errors) !!}
                    </div>
                </div>
                @if (isset($seller))
                    <div class="main_image">
                        @if ($seller->profile->image)
                            <img src="{!! photos_path('sellers') !!}thumb_{!! $seller->profile->image !!}"
                                 alt="{!! $seller->profile->image !!}">

                        @endif

                    </div>
                @endif
                
        </div>
    </section>

</div>