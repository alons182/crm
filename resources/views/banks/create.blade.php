@extends('layouts.template')


@section('content')

 @include('layouts/partials/_breadcumbs', ['page' => 'Bancos'])

    {!! Form::open(['route'=>'banks.store','files'=> true, 'class'=>'form-horizontal']) !!}

        @include('banks/partials/_form')

    {!! Form::close() !!}
	


@endsection
@section('scripts')

@stop
