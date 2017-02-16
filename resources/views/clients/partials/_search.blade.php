
            <div class="filtros " >
               
               
                {!! Form::open(['route' => 'clients','method' => 'get', 'class'=>'form-inline']) !!}

                            <div class="row">
                                 <div class="col-xs-12 col-sm-5 col-md-3">

                                    <div class="form-group">
                                        
                                        {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Buscar'] ) !!}
                                    </div>


                                </div>
                                <div class="col-xs-12 col-sm-5 col-md-3">
                                    <div class="form-group">
                                    {!! Form::select('referred', ['' => '-- Filtrar por referencia --','mail' => 'Correo','facebook' => 'Facebook','website' => 'Sitio Web','vallas' => 'Vallas','others' => 'Otros'], $selectedReference, ['id'=>'referred','class'=>'form-control'] ) !!}
                                    </div>
                                 </div>
                                 <div class="col-xs-12 col-sm-5 col-md-3">
                                    <div class="form-group">
                                    {!! Form::select('seller', ['' => '-- Filtrar por vendedor --'] + $sellers , $selectedSeller, ['id'=>'seller','class'=>'form-control'] ) !!}
                                    </div>
                                 </div>
                                
                            </div>
                             <div class="row">
                                  <div class="col-xs-12 col-sm-5 col-md-3">
                                        <div class="form-group">
                                            {!! Form::select('status', ['' => '-- Filtrar por estatus --'] + ['1' => 'Reservado','2' => 'Aprobado','3' => 'Interesado','4' => 'Formalizado'] , $selectedStatus, ['id'=>'status','class'=>'form-control'] ) !!}
                                        </div>
                                 </div>
                             
                                 <div class="col-xs-12 col-sm-5 col-md-3">
                                     <div class="form-group">
                                     {!! Form::select('project', ['' => '-- Filtrar por proyecto --'] + $projects , $selectedProject, ['id'=>'project','class'=>'form-control'] ) !!}
                                    </div>

                                 </div>
                                 <div class="col-xs-12 col-sm-5 col-md-3">
                                    <div class="form-group">
                                        {!! Form::select('potencial', ['' => '-- Filtrar por potencial --'] + ['1' => 'Alto','2' => 'Medio','3' => 'Bajo'] , $selectedPotencial, ['id'=>'potencial','class'=>'form-control'] ) !!}
                                    </div>
                                 </div>
                                 
                               
                               </div>
                                
                            <div class="row">
                                <div class="col-xs-12 col-sm-5 col-md-3">
                                    <div class="form-group">
                                    {!! Form::select('cita', ['' => '-- Filtrar si asistió a cita --'] + ['0' => 'No','1' => 'Si'] , $selectedCita, ['id'=>'cita','class'=>'form-control'] ) !!}
                                    </div>
                                 </div>
                                 <div class="col-xs-12 col-sm-5 col-md-3">
                                     <div class="form-group ">
                                
                                         
                                            {!! Form::text('date1', $date1,['class'=>'form-control datepicker','placeholder'=>'Filtrar por fecha inicio']) !!}
                                            {!! errors_for('date1',$errors) !!}
                                    </div>
                                </div>
                                 <div class="col-xs-12 col-sm-5 col-md-3">
                                    <div class="form-group ">
                                            {!! Form::text('date2', $date2,['class'=>'form-control datepicker','placeholder'=>'Filtrar por fecha fin']) !!}
                                            {!! errors_for('date2',$errors) !!}
                                        

                                    </div>
                                </div>
                           
                            </div>
                           
                               
                           
                             


                {!! Form::close() !!}

            </div>
