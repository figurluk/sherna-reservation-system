@extends('layouts.admin')

@section('content')

    <form action="{{action('Admin\SettingsController@update')}}" class="form-horizontal" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>System settings</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Max duration of reservation</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="input1" name="max-duration" value="{{config('calendar.max-duration')}}">
                                            <span class="input-group-addon" id="basic-addon2">hours</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Time before start to edit</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="input1" name="duration-for-edit"
                                                   value="{{intval(config('calendar.duration-for-edit'))}}">
                                            <span class="input-group-addon" id="basic-addon2">minutes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Accessible reservation area</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="input1" name="reservation-area"
                                                   value="{{config('calendar.reservation-area')}}">
                                            <span class="input-group-addon" id="basic-addon2">days</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Earlier access to location of reservation</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="input1" name="access_to_location"
                                                   value="{{config('calendar.access_to_location')}}">
                                            <span class="input-group-addon" id="basic-addon2">minutes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Time before end to renew reservation</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="input1" name="renew_reservation"
                                                   value="{{config('calendar.renew_reservation')}}">
                                            <span class="input-group-addon" id="basic-addon2">minutes</span>
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