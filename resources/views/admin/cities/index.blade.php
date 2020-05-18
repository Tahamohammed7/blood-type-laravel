@extends('admin.layouts.adminlte')

@section('page_title')
    City
@endsection
@section('small_title')
    Statistics
@endsection
@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List Of City</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @include('flash::message')
                @can('city-create')
                 <a href="{{url(route('cities.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New City</a>
                @endcan
                    @if(count($cities))
                  <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Governorate</th>
                              @can('city-edit','city-delete')
                                  <th width="280px">Action</th>
                              @endcan
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($cities as $city)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$city->name}}</td>
                              <td>{{$city->governorate->name}}</td>
                              @can('city-edit')
                              <td class="text-center">
                                  <a href="{{url(route('cities.edit',$city->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></i></a>
                              </td>
                              @endcan
                              @can('city-delete')
                              <td class="text-center">
                                  {!! Form::open([
                                    'action' => ['CityController@destroy',$city->id],
                                    'method' => 'delete'
                                    ])
                                     !!}
                                  <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                  {!! Form::close() !!}
                              </td>
                                  @endcan
                          </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
                    @else
                <div class="alert alert-danger" role="alert">
                    No data
                </div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection
