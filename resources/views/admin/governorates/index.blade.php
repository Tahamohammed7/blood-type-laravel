@extends('admin.layouts.adminlte')
@section('page_title')
    Governorate
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
                <h3 class="box-title">List Of Governorates</h3>

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
                 <a href="{{url(route('governorate.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Governorate</a>
                @if(count($governorates))
                  <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Name</th>
                              @can('governorate-edit','governorate-delete')
                              <th width="280px">Action</th>
                                  @endcan
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($governorates as $governorate)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$governorate->name}}</td>
                              @can('governorate-edit')
                              <td class="text-center">
                                  <a href="{{url(route('governorate.edit',$governorate->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></i></a>
                              </td>
                              @endcan
                              @can('governorate-delete')
                              <td class="text-center">
                                  {!! Form::open([
                                    'action' => ['GovernorateController@destroy',$governorate->id],
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
