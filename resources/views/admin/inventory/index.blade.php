@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Inventory items</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{action('Admin\InventoryController@create')}}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Serial number</th>
                            <th>Inventory number</th>
                            <th>Location</th>
                            <th>Note</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($inventoryItems as $inventoryItem)
                            <tr>
                                <td>{{$inventoryItem->name}}</td>
                                <td>{{$inventoryItem->serial_id}}</td>
                                <td>{{$inventoryItem->inventory_id}}</td>
                                <td>{{$inventoryItem->location->name}}</td>
                                <td>{{$inventoryItem->note}}</td>
                                <td>
                                    <form action="{{action('Admin\InventoryController@delete',$inventoryItem->id)}}" class="inline" method="post">
                                        {!! csrf_field() !!}
                                        <a class="btn btn-warning" href="{{action('Admin\InventoryController@edit',$inventoryItem->id)}}"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$inventoryItems->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection