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
                {!! Form::label('fullname','Full Name:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('fullname', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('fullname',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('company','Company:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                   
                    {!! Form::text('company', null,['class'=>'form-control','required'=>'required']) !!}
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
                   
                    {!! Form::email('email', null,['class'=>'form-control','required'=>'required']) !!}
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
                   
                    {!! Form::text('phone1', null,['class'=>'form-control','required'=>'required']) !!}
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
                    {!! Form::textarea('address',null,['class'=>'form-control']) !!}
                    {!! errors_for('address',$errors) !!}
                </div>

            </div>

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

</div>


		
		


