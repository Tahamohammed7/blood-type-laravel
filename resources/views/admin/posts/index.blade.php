@extends('admin.layouts.adminlte')

@section('page_title')
    Post
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
                <h3 class="box-title">List Of Post</h3>

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
                @can('post-create')
                 <a href="{{url(route('posts.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i> New Post</a>
                @endcan
                @if(count($posts))
                  <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead>
                          <tr>
                              <th>#</th>
                              <th>Title</th>
                              <th>Content</th>
                              <th>Image</th>
                              @can('post-edit','post-delete')
                              <th width="280px">Action</th>
                              @endcan
{{--                              <th class="text-center">Edit</th>--}}
{{--                              <th class="text-center">Delete</th>--}}
                          </tr>
                          </thead>
                          <tbody>
                          @foreach($posts as $post)
                          <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$post->title}}</td>
                              <td>{{$post->content}}</td>
                              <td><img src="{{ asset('storage/'.$post->image) }}" width="100px" height="50px"></td>

                              <td>

                                  @can('post-edit')
                                      <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                                  @endcan
                                  @can('post-delete')
                                      {!! Form::open(['method' => 'DELETE','route' => ['posts.destroy', $post->id],'style'=>'display:inline']) !!}
                                      {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                      {!! Form::close() !!}
                                  @endcan
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
