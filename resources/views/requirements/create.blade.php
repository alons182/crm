@extends('layouts.template')


@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Requerimientos de Banco'])

    {!! Form::open(['route'=>'requirements.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('requirements/partials/_form')

    {!! Form::close() !!}
	


@endsection
@section('scripts')

@stop
