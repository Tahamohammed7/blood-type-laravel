@extends('admin.layouts.adminlte')
@section('page_title')
    Users
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
                <h3 class="box-title">List Of User</h3>

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
                @can('user-create')
                <a href="{{url(route('users.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New User</a>
               @endcan
                @if(count($data))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                @can('user-edit','user-delete')
                                <th width="280px">Action</th>
                                    @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                    </td>
                                    @can('user-edit')
                                    <td class="text-center">
                                        <a href="{{url(route('users.edit',$user->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i></i></a>
                                    </td>
                                    @endcan
                                    @can('user-delete')
                                    <td class="text-center">
                                        {!! Form::open([
                                          'action' => ['UserController@destroy',$user->id],
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
