@extends('layouts.admin')

@section('styles')
    <link href="{{asset('summernote/summernote.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')

    <form action="{{action('Admin\PagesController@update',$page->id)}}" class="form-horizontal" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit page</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{action('Admin\PagesController@index')}}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <ul class="nav nav-tabs" style="margin-bottom: 3%">
                            @foreach($lang as $key=>$value)
                                <li class="{{($key==1 ? "active":"")}}">
                                    <a href="#{{$key}}" data-toggle="tab">{{$value}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            @foreach(\App\Models\Language::all() as $lang)
                                <div class="tab-pane fade {{($lang->id==1 ? "active":"")}} in" id="{{$lang->id}}">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="content">Názov:</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name-{{$lang->id}}" class="form-control" value="{{$page->pageText()->ofLang($lang->code)->first()->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="content">Obsah:</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="content-{{$lang->id}}" value="{{$page->pageText()->ofLang($lang->code)->first()->content}}" class="input-info" data-langID="{{$lang->id}}">
                                            <div class="summernote" data-langID="{{$lang->id}}">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('scripts')
    <script src="{{asset('summernote/summernote.js')}}"></script>
    <script type="text/javascript">

		var imageUploadUrlSum = "{{action('Admin\AdminController@saveImage')}}";

		$('.summernote').summernote({
			height: 200,
			lang: 'sk-SK'
		});

		// Initialize summernote plugin
		$('.summernote').on('summernote.change', function (we, contents, $editable) {
			$(".input-info[data-langID='" + $(we.target).attr('data-langID') + "']").val(contents);
		});

        @foreach(\App\Models\Language::all() as $lang)
		if ($(".input-info[data-langID='{{$lang->id}}']").val() != '') {
			$(".summernote[data-langID='{{$lang->id}}']").summernote('code', $(".input-info[data-langID='{{$lang->id}}']").val());
		}
        @endforeach
    </script>
@endsection