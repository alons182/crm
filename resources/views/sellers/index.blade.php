@extends('layouts.template')

@section('content')
	@include('layouts/partials/_breadcumbs', ['page' => 'Sellers'])

	 <section class="panel">
        <div class="panel-heading">
            {!! link_to_route('sellers.create','New Seller',null,['class'=>'btn btn-success']) !!}
               @include('sellers/partials/_search')
        </div>
        <div class="panel-body no-padding">


                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>name</th>
                                  <th>Email</th>
                                  <th>Assigned Clients</th>
                                  <th>Created</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($sellers as $seller)
                                <tr>
                                    <td>{!! $seller->id !!}</td>
                                    <td>{!! $seller->name !!}
                                    <td>{!! $seller->email !!}</td>
                                    <td>
                                       @foreach($seller->clients as $client)
                                           <a class="btn btn-info btn-sm" href="{!! URL::route('clients.edit', [$client->id]) !!}">
                                             <i class="fa fa-briefcase mg-r-xs"></i>
                                             {!! $client->fullname !!}
                                            </a>
                                            
                                        @endforeach
                                    </td>
                                    <td class="center">{!! $seller->created_at !!}</td>
                                   
                                    
                                    <td class="center">
                                        @can('edit_sellers')
                                        <a class="btn btn-info" href="{!! URL::route("sellers.edit", [$seller->id]) !!}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete_sellers')
                                         <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route("sellers.destroy", [$seller->id]) !!}">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                        @endcan


                                    </td>
                                </tr>
                            @endforeach
                          </tbody>
                          <tfoot>

                                      @if ($sellers)
                                          <td  colspan="10" class="pagination-container">{!!$sellers->appends(['q' => $search])->render()!!}</td>
                                           @endif


                                  </tfoot>
                      </table>


                </div>
        </div>
     </section>




{!! Form::open(array('method' => 'post', 'id' => 'form-active-inactive')) !!}{!! Form::close() !!}
{!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}

@stop