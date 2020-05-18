@extends('admin.layouts.adminlte')
@inject('post','App\Post')
@section('page_title')
   Create Post
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Create Post</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @include('admin.layouts.message')
               {!! Form::model($post,[
                    'action' => 'PostController@store','enctype' => 'multipart/form-data'
               ]) !!}
                <div class="form-group">
                    <label for="selectCategory">Select a Category</label>
                    <select name="category_id" class="form-control" id="selectCategory">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                 @include('admin.posts.form')
               {!! Form::close()  !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection
