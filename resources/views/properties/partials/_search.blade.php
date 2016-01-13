
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'properties','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">


                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Search'] ) !!}


                            </div>
                             <div class=" form-group">

                                {!! Form::select('status', ['' => '-- Select Status --','0' => 'Pending','1' => 'Free','2' => 'Sold'], $selectedStatus, ['id'=>'status','class'=>'form-control'] ) !!}

                             </div>

                {!! Form::close() !!}

            </div>
