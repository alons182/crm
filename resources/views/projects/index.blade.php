@extends('layouts.template')

@section('content')
    @include('layouts/partials/_breadcumbs', ['page' => 'Proyectos'])

    <section class="panel">
        <div class="panel-heading" style="overflow: hidden;">
            {!! link_to_route('projects.create','Nuevo Proyecto',null,['class'=>'btn btn-success']) !!}
            @include('projects/partials/_search')
        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['projects_option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'Estas seguro?']) !!}
            
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

                    @foreach ($projects as $project)
                        <tr>
                            <td>{!! Form::checkbox('chk_project[]', $project->id, null, ['class' => 'chk-item']) !!}</td>
                            <td>{!!$project->id!!}</td>
                            <td>{!!$project->name!!}</td>
                            
                            
                            <td class="center">{!! $project->created_at !!}</td>   

                            <td class="center">
                               
                                <a class="btn btn-info" href="{!! URL::route('projects.edit', [$project->id]) !!}">
                                <i class="fa fa-edit"></i>
                                </a>
                              
                                
                                <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route('projects.destroy', [$project->id]) !!}">
                                <i class="fa fa-trash-o"></i>
                                </button>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($projects)
                        <td  colspan="10" class="pagination-container">{!!$projects->appends(['q' => $search])->render()!!}</td>
                    @endif


                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </section>






    {!! Form::open(array('method' => 'post', 'id' => 'form-free-sold')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'Estas seguro?']) !!}{!! Form::close() !!}
@stop