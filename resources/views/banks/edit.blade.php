@extends('layouts.template')

@section('content')
 @include('layouts/partials/_breadcumbs', ['page' => 'Bancos'])
	
	{!! Form::model($bank, ['method' => 'put', 'route' => ['banks.update', $bank->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('banks/partials/_form', ['buttonText' => 'Actualizar Banco'])
	 
	{!! Form::close() !!}
    
@endsection
@section('scripts')
<script src="/vendor/jquery.sortable.js"></script>
<script src="/vendor/fuelux/checkbox.js"></script>
	<script type="text/javascript">
	
		$(".handles").sortable({
	        handle: "span"
	    });
	    
		
	</script>
@stop



