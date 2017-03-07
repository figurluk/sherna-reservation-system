@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pages</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Public</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td>{{$page->pageText()->ofLang('cz')->first()->name}}</td>
                                <td><span class="label label-{{$page->public ? 'success':'warning'}}">{{$page->public ? 'Public':'In prepare'}}</span></td>
                                <td>
                                    <a class="btn btn-warning" href="{{action('Admin\PagesController@edit',$page->id)}}"><i
                                                class="fa fa-pencil"></i></a>
                                    @if($page->code!='domu')
                                        @if($page->public)
                                            <a href="{{action('Admin\PagesController@unvisible',$page->id)}}" class="btn btn-primary"><i
                                                        class="fa fa-eye-slash"></i></a>
                                        @else
                                            <a href="{{action('Admin\PagesController@visible',$page->id)}}" class="btn btn-danger"><i class="fa fa-eye"></i></a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$pages->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection