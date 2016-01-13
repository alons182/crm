@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">

@stop
@section('content')
 @include('layouts/partials/_breadcumbs', ['page' => 'Clients'])
	
	{!! Form::model($client, ['method' => 'put', 'route' => ['clients.update', $client->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('clients/partials/_form', ['buttonText' => 'Update Client'])
	 
	{!! Form::close() !!}
    @include('clients/partials/_modal')
   
@endsection

@section('scripts')

    <script src="/vendor/bootstrap-select/bootstrap-select.js"></script>
    <script src="/vendor/jquery.sortable.js"></script>
    <script src="/vendor/fuelux/checkbox.js"></script>
	<script type="text/javascript">
		$(".handles").sortable({
	        handle: "span"
	    });
	</script>
@stop

