@extends('layouts.admin')

@section('content')

    <form action="{{action('Admin\LocationsController@updateStatus',$locationStatus->id)}}" class="form-horizontal" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update location status</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{action('Admin\LocationsController@index')}}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="input1" name="name" value="{{$locationStatus->name }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <div class="checkbox">
                                            <label>
                                                <input type="hidden" name="opened" value="0">
                                                <input type="checkbox" name="opened" value="1" {{$locationStatus->opened ? 'checked':''}}> Opened
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection