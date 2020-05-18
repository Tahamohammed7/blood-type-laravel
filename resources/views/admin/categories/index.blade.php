@extends('admin.layouts.adminlte')

@section('page_title')
    Category
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
                <h3 class="box-title">List Of Category</h3>

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
                 <a href="{{url(route('categories.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Category</a>
                @if(count($categories))
                  <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th class="text-center">Edit</th>
                              <th class="text-center">Delete</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($categories as $category)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$category->name}}</td>
                              <td class="text-center">
                                  <a href="{{url(route('categories.edit',$category->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></i></a>
                              </td>
                              <td class="text-center">
                                  {!! Form::open([
                                    'action' => ['CategoryController@destroy',$category->id],
                                    'method' => 'delete'
                                    ])
                                     !!}
                                  <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                  {!! Form::close() !!}
                              </td>
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
