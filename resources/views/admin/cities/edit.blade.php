@extends('admin.layouts.adminlte')
@section('page_title')
   Edit City
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Edit City</h3>

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
               {!! Form::model($city,[
                    'action' => ['CityController@update',$city->id],
                    'method' => 'put'
               ]) !!}
                <div class="form-group">
                    <label for="selectGovernorate">Select a Governorate</label>
                    <select name="governorate_id" class="form-control" id="selectGovernorate">
                        @foreach ($governorates as $governorate)
                            <option value="{{$governorate->id}}">{{$governorate->name}}</option>
                        @endforeach
                    </select>
                </div>
                 @include('admin.cities.form')
               {!! Form::close()  !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection
