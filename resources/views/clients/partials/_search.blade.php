
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'clients','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">


                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Search'] ) !!}


                            </div>
                            <div class=" form-group">

                                {!! Form::select('referred', ['' => '-- Select reference --','mail' => 'Mail','facebook' => 'Facebook','website' => 'Website','vallas' => 'Vallas','others' => 'Others'], $selectedReference, ['id'=>'referred','class'=>'form-control'] ) !!}

                             </div>
                             <div class=" form-group">

                                {!! Form::select('seller', ['' => '-- Filter by seller --'] + $sellers , $selectedSeller, ['id'=>'seller','class'=>'form-control'] ) !!}

                             </div>

                {!! Form::close() !!}

            </div>
