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
                @if(count($contacts))
                  <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Subject</th>
                              <th>Message</th>
                              @can('content-delete')
                              <th class="text-center">Delete</th>
                                  @endcan
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($contacts as $contact)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$contact->name}}</td>
                              <td>{{$contact->email}}</td>
                              <td>{{$contact->phone}}</td>
                              <td>{{$contact->subject}}</td>
                              <td>{{$contact->message}}</td>
                              @can('content-delete')
                              <td class="text-center">
                                  {!! Form::open([
                                    'action' => ['ContactController@destroy',$contact->id],
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
