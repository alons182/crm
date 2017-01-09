@extends('layouts.template')

@section('content')
 @include('layouts/partials/_breadcumbs', ['page' => 'Proyectos'])
	
	{!! Form::model($project, ['method' => 'put', 'route' => ['projects.update', $project->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('projects/partials/_form', ['buttonText' => 'Actualizar Proyecto'])
	 
	{!! Form::close() !!}
    
@endsection
@section('scripts')
<script src="/vendor/jquery.sortable.js"></script>
<script src="/vendor/fuelux/checkbox.js"></script>
<script src="/vendor/jquery.maskedinput.min.js"></script>
	<script type="text/javascript">
	
		$(".handles").sortable({
	        handle: "span"
	    });
	    
		$("#owner_phone1").mask("9999-9999");
		$("#owner_phone2").mask("9999-9999");
		
	</script>
@stop



