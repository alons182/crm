@extends('layouts.template')


@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Proyects'])

    {!! Form::open(['route'=>'projects.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('projects/partials/_form')

    {!! Form::close() !!}
	


@endsection
@section('scripts')
<script src="/vendor/jquery.maskedinput.min.js"></script>
	<script type="text/javascript">
		
		$("#owner_phone1").mask("9999-9999");
		$("#owner_phone2").mask("9999-9999");
		
	</script>
@stop
