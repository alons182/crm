@extends('layouts.template')

@section('content')

	 <div class="row mg-b">
        <div class="col-xs-6">
            <h3 class="no-margin">Panel Control</h3>
            <small>Bienvenido, {{ $currentUser->name }}</small>
        </div>
        <div class="col-xs-6 text-right">
            <a href="#" class="fa fa-flash pull-right pd-sm toggle-chat toggle-sidebar" data-toggle="off-canvas" data-move="rtl">
                <span class="badge bg-danger animated flash">6</span>
            </a>
        </div>
    </div>

    <div class="row">
        @can('create_sellers')
        <div class="col-md-3 col-sm-6 col-xs-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="circle-icon bg-success">
                        <i class="fa fa-users"></i>
                    </div>
                    <div>

                         <a href="/sellers" style="display: block;">
                             <h3 class="no-margin">Vendedores</h3>
                             
                         </a>
                    </div>
                </div>
            </section>
        </div>
        @endcan
         <div class="col-md-3 col-sm-6 col-xs-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="circle-icon bg-danger">
                        <i class="fa fa-coffee"></i>
                    </div>
                    <div>

                        <a href="/clients" style="display: block;">
                            <h3 class="no-margin">Clientes</h3>
                            
                        </a>
                    </div>
                </div>
            </section>
        </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="circle-icon bg-danger">
                        <i class="fa fa-home"></i>
                    </div>
                    <div>

                        <a href="/properties" style="display: block;">
                            <h3 class="no-margin">Propiedades</h3>
                            
                        </a>
                    </div>
                </div>
            </section>
        </div>
        
    </div>



@endsection