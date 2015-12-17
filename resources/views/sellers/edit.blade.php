@extends('templates.template')

@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">

@stop
@section('content')
    @include('templates/partials/_breadcumbs', ['page' => 'Sellers'])

        {!! Form::model($seller, ['method' => 'put', 'route' => ['sellers.update', $seller->id],'files'=> true, 'class'=>'form-horizontal' ]) !!}
        		 @include('sellers/partials/_form',['buttonText' => 'Update Seller'])
        {!! Form::close() !!}
		@include('sellers/partials/_modal')

@stop
@section('scripts')
    <script src="/vendor/bootstrap-select/bootstrap-select.js"></script>

@stop