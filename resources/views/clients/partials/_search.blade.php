
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'clients','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">


                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Buscar'] ) !!}


                            </div>
                            <div class=" form-group">

                                {!! Form::select('referred', ['' => '-- Filtrar por referencia --','mail' => 'Correo','facebook' => 'Facebook','website' => 'Sitio Web','vallas' => 'Vallas','others' => 'Otros'], $selectedReference, ['id'=>'referred','class'=>'form-control'] ) !!}

                             </div>
                             <div class=" form-group">

                                {!! Form::select('seller', ['' => '-- Filtrar por vendedor --'] + $sellers , $selectedSeller, ['id'=>'seller','class'=>'form-control'] ) !!}

                             </div>
                              <div class=" form-group">

                                {!! Form::select('status', ['' => '-- Filtrar por estatus --'] + ['1' => 'En Tramite','2' => 'Aprobado','3' => 'Interesado','4' => 'Denegado'] , $selectedStatus, ['id'=>'status','class'=>'form-control'] ) !!}

                             </div>
                             <div class=" form-group">

                                {!! Form::select('debts', ['' => '-- Filtrar por deudas --'] + ['1' => 'No Deudas','2' => 'Si Deudas','3' => 'Por Consultar','4' => 'Monto especifico'] , $selectedDebts, ['id'=>'debts','class'=>'form-control'] ) !!}

                             </div>
                             <div class=" form-group">

                                {!! Form::select('potencial', ['' => '-- Filtrar por potencial --'] + ['1' => 'Alto','2' => 'Medio','3' => 'Bajo'] , $selectedPotencial, ['id'=>'potencial','class'=>'form-control'] ) !!}

                             </div>
                               
                               <div class="form-group">
                            
                                     
                                    {!! Form::text('date1', $date1,['class'=>'form-control datepicker','placeholder'=>'Filtrar por fecha']) !!}
                                    {!! errors_for('date1',$errors) !!}
                                    {!! Form::text('date2', $date2,['class'=>'form-control datepicker','placeholder'=>'Filtrar por fecha']) !!}
                                    {!! errors_for('date2',$errors) !!}
                                

                            </div>


                {!! Form::close() !!}

            </div>
