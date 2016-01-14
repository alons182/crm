@extends('layouts.template')

@section('content')
    @include('layouts/partials/_breadcumbs', ['page' => 'Clients'])

    <section class="panel">
        <div class="panel-heading" style="overflow: hidden;">
            {!! link_to_route('clients.create','New Client',null,['class'=>'btn btn-success']) !!}
            @include('clients/partials/_search')
        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'You are sure?']) !!}
             @can('delete_clients')
            <button type="submit" class="btn-multiple btn btn-danger btn-sm " data-action="delete" title="Delete"><i class="fa fa-trash-o"></i></button>
            @endcan
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{!! Form::checkbox('select_all', 0, null, ['id' => 'select-all']) !!}
                            {!! Form::hidden('select_action', null, ['id' => 'select-action']) !!} 
                         </th>
                        <th>#</th>
                        <th>IDE</th>
                        <th>Full Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        
                        <th>Created</th>

                        
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($clients as $client)
                        <tr>
                            <td>{!! Form::checkbox('chk_client[]', $client->id, null, ['class' => 'chk-item']) !!}</td>
                            <td>{!!$client->id!!}</td>
                             <td>{!! $client->ide !!}</td>
                            <td>{!!$client->fullname!!}</td>
                            <td>{!! $client->company !!}</td>
                             <td>{!! $client->email !!}</td>
                              <!-- <td>
                               @foreach($client->sellers as $seller)
                                    @can('edit_sellers')
                                       <a class="btn btn-info btn-sm" href="{!! URL::route('sellers.edit', [$seller->id]) !!}">
                                         <i class="fa fa-user mg-r-xs"></i>
                                         {!! $seller->name !!}
                                        </a>
                                    @else
                                        <span class="btn btn-info btn-sm">
                                         <i class="fa fa-user mg-r-xs"></i>
                                         {!! $seller->name !!}
                                        </span>
                                    @endcan
                                @endforeach
                               </td>-->
                            <td class="center">{!! $client->created_at !!}</td>

                            <td class="center">
                               
                                <a class="btn btn-info" href="{!! URL::route('clients.edit', [$client->id]) !!}">
                                <i class="fa fa-edit"></i>
                                </a>
                              
                                @can('delete_clients')
                                <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route('clients.destroy', [$client->id]) !!}">
                                <i class="fa fa-trash-o"></i>
                                </button>
                                 @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($clients)
                        <td  colspan="10" class="pagination-container">{!!$clients->appends(['q' => $search])->render()!!}</td>
                    @endif


                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </section>






    {!! Form::open(array('method' => 'post', 'id' => 'form-pub-unpub')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'post', 'id' => 'form-feat-unfeat']) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}
@stop