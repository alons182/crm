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

   <section class="panel">
        <header class="panel-heading">
            {!! Form::label('notification','Notification:',['class'=>'control-label'])!!}
        </header>
        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('notification_date','Date:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-xs-5">
                        <input type="text" class="form-control datepicker" name="notification_date" value="{{ isset($task) && ($task->notification_date != '0000-00-00 00:00:00') ? $task->notification_date : '' }}">
                            
                            {!! errors_for('notification_date',$errors) !!}
                        </div>
                        <div class="col-xs-2">

                            {!! Form::text('notification_time', null,['class'=>'form-control timepicker'])!!}
                            {!! errors_for('notification_time',$errors) !!}
                        
                        
                            
                        </div>
                        
                    </div>
                </div>



            </div>
            <div class="form-group">
                {!! Form::label('notification_reminder_date','Remaind Time:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-xs-5">
                            <input type="text" class="form-control datepicker" name="notification_reminder_date" value="{{ isset($task) && ($task->notification_reminder_date != '0000-00-00 00:00:00') ? $task->notification_reminder_date : '' }}">

                            {!! errors_for('notification_reminder_date',$errors) !!}
                        </div>
                        <div class="col-xs-2">

                            {!! Form::text('notification_reminder_time', null,['class'=>'form-control timepicker'])!!}
                            {!! errors_for('notification_reminder_time',$errors) !!}
                        
                        
                            
                        </div>
                        
                    </div>
                </div>



            </div>
            <!--<div class="form-group">
               {!! Form::label('notification_reminder','Remaind Time:',['class'=>'col-sm-2 control-label']) !!}

                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-xs-2">
                           
                            {!! Form::select('notification_reminder',['30'=>'30','1'=>'60'], null,['class'=>'form-control'])!!}
                            {!! errors_for('notification_reminder',$errors) !!}
                        </div>
                        <div class="col-xs-3">

                            {!! Form::select('notification_choices_time',['mins'=>'Minutes'], null,['class'=>'form-control'])!!}
                            {!! errors_for('notification_choices_time',$errors) !!}
                        
                        
                            
                        </div>
                        
                    </div>
                </div>
            </div>-->
            <div class="form-group">
             {!! Form::label('notification_to','Notification To:',['class'=>'col-sm-2 control-label']) !!}
             <div class="col-sm-10">
              {!! Form::text('notification_to', (isset($task)) ? $task->notification_to : $currentUser->email ,['class'=>'form-control','required'=>'required']) !!}
              {!! errors_for('notification_to',$errors) !!}
             </div>
            
                
        </div>

    </section>
</div>



		
		


