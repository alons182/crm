
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'sellers','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">


                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Buscar'] ) !!}


                            </div>

                {!! Form::close() !!}

            </div>
