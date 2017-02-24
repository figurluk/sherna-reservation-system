@extends('layouts.admin')

@section('content')

    <form action="{{action('Admin\InventoryController@store')}}" class="form-horizontal" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create inventory item</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{action('Admin\InventoryController@index')}}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="input1" name="name" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Invetory number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="input1" name="inventory_id" value="{{old('inventory_id')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Serial number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="input1" name="serial_id" value="{{old('serial_id')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input2" class="col-sm-4 control-label">Location</label>
                                    <div class="col-sm-8">
                                        <select name="location_id" id="input2" class="form-control">
                                            @foreach(\App\Models\Location::get() as $location)
                                                <option value="{{$location->id}}">{{$location->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="note" class="col-sm-2 control-label">Note</label>
                                    <div class="col-sm-10">
                                        <textarea name="note" id="note" class="form-control" rows="3">{{old('note')}}</textarea>
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