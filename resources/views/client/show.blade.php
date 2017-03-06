@extends('layouts.client')

@section('content')

    <div class="jumbotron">
        <div class="container">
            <h1>Vitajte na strankach SHerny</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                {!! $page->content !!}
            </div>
        </div>
    </div>

@endsection