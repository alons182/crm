@extends('layouts.template')

@section('content')
    @include('layouts/partials/_breadcumbs', ['page' => 'Properties'])

    <section class="panel">
        <div class="panel-heading" style="overflow: hidden;">
            {!! link_to_route('properties.create','New Property',null,['class'=>'btn btn-success']) !!}
            @include('properties/partials/_search')
        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['properties_option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'You are sure?']) !!}
            
            <button type="submit" class="btn-multiple btn btn-danger btn-sm " data-action="delete" title="Delete"><i class="fa fa-trash-o"></i></button>
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{!! Form::checkbox('select_all', 0, null, ['id' => 'select-all']) !!}
                            {!! Form::hidden('select_action', null, ['id' => 'select-action']) !!} 
                         </th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Owner Telephone</th>
                        <th>Assigned Clients</th>
                        <th>status</th>
                        <th>Created</th>

                        
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($properties as $property)
                        <tr>
                            <td>{!! Form::checkbox('chk_property[]', $property->id, null, ['class' => 'chk-item']) !!}</td>
                            <td>{!!$property->id!!}</td>
                            <td>{!!$property->name!!}</td>
                            <td>{!! $property->owner !!}</td>
                             <td>{!! $property->owner_phone1 !!}</td>
                               <td>
                               @foreach($property->clients as $client)
                                    @can('edit_clients')
                                       <a class="btn btn-info btn-sm" href="{!! URL::route('clients.edit', [$client->id]) !!}">
                                         <i class="fa fa-user mg-r-xs"></i>
                                         {!! $client->fullname !!}
                                        </a>
                                    @else
                                        <span class="btn btn-info btn-sm">
                                         <i class="fa fa-user mg-r-xs"></i>
                                         {!! $client->fullname !!}
                                        </span>
                                    @endcan
                                @endforeach
                               </td>
                            <td class="center">
                                 @if ($property->status)
                                    @if($property->status == 1)
                                        <button type="submit"  class="btn btn-success btn-xs" form="form-free-sold" formaction="{!! URL::route('properties.sold', [$property->id]) !!}">Free</button>
                                    @elseif($property->status == 2)
                                        <button type="submit"  class="btn btn-warning btn-xs" form="form-free-sold" formaction="{!! URL::route('properties.free', [$property->id]) !!}">Sold</button>
                                   
                                    @endif

                                @else
                                    @can('authorize_property')
                                        <button type="submit"  class="btn btn-danger btn-xs  "form="form-free-sold" formaction="{!! URL::route('properties.free', [$property->id]) !!}" >Pending</button>
                                    @else 
                                        <a  class="btn btn-danger btn-xs"  href="#" >Pending</a>
                                    @endcan
                                @endif

                                
                            </td>   
                            <td class="center">{!! $property->created_at !!}</td>

                            <td class="center">
                               
                                <a class="btn btn-info" href="{!! URL::route('properties.edit', [$property->id]) !!}">
                                <i class="fa fa-edit"></i>
                                </a>
                              
                                
                                <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route('properties.destroy', [$property->id]) !!}">
                                <i class="fa fa-trash-o"></i>
                                </button>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($properties)
                        <td  colspan="10" class="pagination-container">{!!$properties->appends(['q' => $search])->render()!!}</td>
                    @endif


                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </section>






    {!! Form::open(array('method' => 'post', 'id' => 'form-free-sold')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}
@stop