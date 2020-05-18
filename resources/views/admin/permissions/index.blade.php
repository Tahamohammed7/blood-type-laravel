@extends('admin.layouts.adminlte')
@section('page_title')
    Permission
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Premission Management</h2>
            </div>
            <div class="pull-right">
                @can('role-create')
                    <a class="btn btn-success" href="{{ route('permissions.create') }}"> Create New Role</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            @can('permission-edit','permission-delete')
            <th width="280px">Action</th>
                @endcan
        </tr>
        @foreach ($permissions as $key => $permission)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $permission->name }}</td>
                <td>
                    @can('role-edit')
                        <a class="btn btn-primary" href="{{ route('permissions.edit',$permission->id) }}">Edit</a>
                    @endcan
                    @can('role-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
    </table>


    {!! $permissions->render() !!}


    <p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>
@endsection
