@extends('layouts.template')

@section('content')
    @include('layouts/partials/_breadcumbs', ['page' => 'Bancos'])

    <section class="panel">
        <div class="panel-heading" style="overflow: hidden;">
            {!! link_to_route('banks.create','Nuevo Banco',null,['class'=>'btn btn-success']) !!}
            @include('banks/partials/_search')
        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['banks_option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'Estas seguro?']) !!}
            
            <button type="submit" class="btn-multiple btn btn-danger btn-sm " data-action="delete" title="Delete"><i class="fa fa-trash-o"></i></button>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{!! Form::checkbox('select_all', 0, null, ['id' => 'select-all']) !!}
                            {!! Form::hidden('select_action', null, ['id' => 'select-action']) !!} 
                         </th>
                        <th>#</th>
                        <th>Nombre</th>
                       
                        <th>Creado</th>
                       
                        
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($banks as $bank)
                        <tr>
                            <td>{!! Form::checkbox('chk_bank[]', $bank->id, null, ['class' => 'chk-item']) !!}</td>
                            <td>{!!$bank->id!!}</td>
                            <td>{!!$bank->name!!}</td>
                            
                            
                            <td class="center">{!! $bank->created_at !!}</td>   

                            <td class="center">
                               
                                <a class="btn btn-info" href="{!! URL::route('banks.edit', [$bank->id]) !!}">
                                <i class="fa fa-edit"></i>
                                </a>
                              
                                
                                <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route('banks.destroy', [$bank->id]) !!}">
                                <i class="fa fa-trash-o"></i>
                                </button>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($banks)
                        <td  colspan="10" class="pagination-container">{!!$banks->appends(['q' => $search])->render()!!}</td>
                    @endif


                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </section>






   
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'Estas seguro?']) !!}{!! Form::close() !!}
@stop