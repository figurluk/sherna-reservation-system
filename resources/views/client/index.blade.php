@extends('layouts.client')


@section('content')

    <div class="jumbotron">
        <div class="container">
            <h1>{{trans('general.banner.title')}}</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                {!! $page->pageText()->ofLang(Config::get('app.locale'))->first()->content !!}
            </div>
        </div>
    </div>

@endsection
