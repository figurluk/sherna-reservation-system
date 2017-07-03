@extends('layouts.admin')

@section('content')

    <form action="{{action('Admin\LocationsController@update',$location->id)}}" class="form-horizontal" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update location</h2>
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
                                        <input type="text" class="form-control" id="input1" name="name" value="{{$location->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="location_uid" class="col-sm-4 control-label">Location UID</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="location_uid" name="location_uid" value="{{$location->location_uid}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="reader_uid" class="col-sm-4 control-label">Reader UID</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="reader_uid" name="reader_uid" value="{{$location->reader_uid}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input2" class="col-sm-4 control-label">Locations status</label>
                                    <div class="col-sm-8">
                                        <select name="location_status_id" id="input2" class="form-control">
                                            @foreach(\App\Models\LocationStatus::get() as $status)
                                                <option value="{{$status->id}}" {{$location->status->id == $status->id ? 'selected':''}}>{{$status->name}}</option>
                                            @endforeach
                                        </select>
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