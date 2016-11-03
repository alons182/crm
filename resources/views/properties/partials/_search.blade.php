
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'properties','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">


                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Buscar'] ) !!}


                            </div>
                             <div class=" form-group">

                                {!! Form::select('status', ['' => '-- Selecciona Estatus --','0' => 'Pendiente','1' => 'Libre','2' => 'Vendida'], $selectedStatus, ['id'=>'status','class'=>'form-control'] ) !!}

                             </div>
                             <div class=" form-group">

                                {!! Form::select('province', ['' => '-- Selecciona Ubicació --','Guanacaste' => 'Guanacaste','San Jose' => 'San Jose','Alajuela' => 'Alajuela','Cartago' => 'Cartago','Heredia' => 'Heredia','Puntarenas' => 'Puntarenas','Limón' => 'Limón'], $selectedLocation, ['id'=>'province','class'=>'form-control'] ) !!}

                             </div>

                {!! Form::close() !!}

            </div>
