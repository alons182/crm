@extends('layouts.template')


@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Tasks'])

    {!! Form::open(['route'=>'tasks.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('tasks/partials/_form')

    {!! Form::close() !!}
	


@endsection

