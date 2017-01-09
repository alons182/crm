<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
           
                {!! Form::submit(isset($buttonText) ? $buttonText : 'Crear Requerimiento',['class'=>'btn btn-primary'])!!}
                {!! link_to_route('requirements',  'Cancelar', null, ['class'=>'btn btn-default'])!!}
                
        </header>
        <div class="panel-body">
          @if(isset($requirement))
                {!! Form::hidden('bank_id',  $requirement->bank_id) !!}
            @endif
            @if(isset($bank_id))
                {!! Form::hidden('bank_id',  $bank_id) !!}
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



		
		


