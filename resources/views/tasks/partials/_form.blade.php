<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
           
                {!! Form::submit(isset($buttonText) ? $buttonText : 'Create Task',['class'=>'btn btn-primary'])!!}
                {!! link_to_route('clients.edit',  'Cancel', (isset($client_id)) ? $client_id : $task->client_id, ['class'=>'btn btn-default'])!!}
                
        </header>
        <div class="panel-body">

            @if(isset($client_id))
                {!! Form::hidden('client_id',  $client_id) !!}
            @endif

            <div class="form-group">
                {!! Form::label('title','Title:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('title', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('title',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('description','Description:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                    {!! errors_for('description',$errors) !!}
                </div>

            </div>
            @if(isset($task))
               <div class="form-group">
                    {!! Form::label('status','Status:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::select('status',['0' => 'Pending', '1' => 'Complete'], $task->status,['class'=>'form-control','required'=>'required'])!!}
                        {!! errors_for('status',$errors) !!}
                    </div>
                </div>
            @endif
            

        </div>
    </section>

</div>
<div class="col-lg-6">

   
</div>



		
		


