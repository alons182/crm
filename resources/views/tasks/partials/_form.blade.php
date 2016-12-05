<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
                @if(isset($task))
                    @if(auth()->user()->isAsigned($task->client_id) || auth()->user()->hasRole('admin'))
                         {!! Form::submit(isset($buttonText) ? $buttonText : 'Crear Tarea',['class'=>'btn btn-primary'])!!}
                    @endif
                @else
                    {!! Form::submit(isset($buttonText) ? $buttonText : 'Crear Tarea',['class'=>'btn btn-primary'])!!}
                @endif
                {!! link_to_route('clients.edit',  'Cancelar', (isset($client_id)) ? $client_id : $task->client_id, ['class'=>'btn btn-default'])!!}
                
        </header>
        <div class="panel-body">

            @if(isset($client_id))
                {!! Form::hidden('client_id',  $client_id) !!}
            @endif

            <div class="form-group">
                {!! Form::label('title','Titulo:',['class'=>'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('title', null,['class'=>'form-control','required'=>'required']) !!}
                    {!! errors_for('title',$errors) !!}
                </div>


            </div>
            <div class="form-group">
                {!! Form::label('description','Descripcion:',['class'=>'col-sm-2 control-label'])!!}
                <div class="col-sm-10">
                    {!! Form::textarea('description',null,['class'=>'form-control']) !!}
                    {!! errors_for('description',$errors) !!}
                </div>

            </div>
            @if(isset($task))
               <div class="form-group">
                    {!! Form::label('status','Estatus:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::select('status',['0' => 'Pendiente', '1' => 'Completada'], $task->status,['class'=>'form-control','required'=>'required'])!!}
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
            {!! Form::label('notification','Notificación:',['class'=>'control-label'])!!}
        </header>
        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('notification_date','Fecha:',['class'=>'col-sm-2 control-label']) !!}
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
                {!! Form::label('notification_reminder_date','Recordatorio:',['class'=>'col-sm-2 control-label']) !!}
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
             {!! Form::label('notification_to','Notificar a:',['class'=>'col-sm-2 control-label']) !!}
             <div class="col-sm-10">
              {!! Form::text('notification_to', (isset($task)) ? $task->notification_to : $currentUser->email ,['class'=>'form-control','required'=>'required']) !!}
              {!! errors_for('notification_to',$errors) !!}
             </div>
            
                
        </div>

    </section>
</div>



		
		


