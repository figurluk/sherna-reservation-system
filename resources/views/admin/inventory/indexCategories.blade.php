@extends('layouts.admin')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Inventory categories</h2>
					<div class="pull-right">
						<a class="btn btn-primary" href="{{action('Admin\InventoryController@createCategories')}}"><i
									class="fa fa-plus"></i></a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					
					<table class="table">
						<thead>
						<tr>
							<th>Name</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@foreach($inventoryCategories as $inventoryCategory)
							<tr>
								<td>{{$inventoryCategory->texts()->ofLang('en')->first()->name}}</td>
								<td>
									<form action="{{action('Admin\InventoryController@deleteCategories',$inventoryCategory->id)}}"
										  class="inline" method="post">
										{!! csrf_field() !!}
										<a class="btn btn-warning"
										   href="{{action('Admin\InventoryController@editCategories',$inventoryCategory->id)}}"><i
													class="fa fa-pencil"></i></a>
										@if($inventoryCategory->id != 1)
											<button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>
											</button>
										@endif
									</form>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					{{$inventoryCategories->render()}}
				</div>
			</div>
		</div>
	</div>

@endsection