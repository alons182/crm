
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
                              <div class=" form-group">

                                {!! Form::select('status', ['' => '-- Filter by status --'] + ['1' => 'Finalizado','2' => 'Pre-Aprobado','3' => 'Interesado','4' => 'Denegado'] , $selectedStatus, ['id'=>'status','class'=>'form-control'] ) !!}

                             </div>
                               
                               <div class="form-group">
                            
                                     
                                    {!! Form::text('date1', $date1,['class'=>'form-control datepicker','placeholder'=>'Filter by date']) !!}
                                    {!! errors_for('date1',$errors) !!}
                                    {!! Form::text('date2', $date2,['class'=>'form-control datepicker','placeholder'=>'Filter by date']) !!}
                                    {!! errors_for('date2',$errors) !!}
                                

                            </div>


                {!! Form::close() !!}

            </div>
