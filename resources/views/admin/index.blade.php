@extends('layouts.admin')

@section('content')
	<div class="row">
		@foreach(\App\Models\Location::get() as $location)
			<div class="col-md-4">
				<div class="x_panel">
					<div class="x_title">
						<h2>Actual reservation for: <b>{{$location->name}}</b></h2>
						<div class="pull-right">
							<span class="label label-{{$location->status->opened ? 'success':'danger'}}">{{$location->status->name}}</span>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						
						<?php
						
						$actualReservation = App\Models\Reservation::where('location_id', $location->id)
							->whereNull('canceled_at')
							->where('start', '<=', date('Y-m-d H:i:s'))
							->where('end', '>=', date('Y-m-d H:i:s'))->first();
						?>
						
						@if($actualReservation!=null)
							
							<div class="twPc-div">
								<a class="twPc-bg twPc-block"></a>
								
								<div>
									
									<a title="{{$actualReservation->ownerName()}}" target="_blank" rel="noopener"
									   href="https://is.sh.cvut.cz/users/{{$actualReservation->tenant_uid}}"
									   class="twPc-avatarLink">
										<img alt="{{$actualReservation->ownerName()}}"
											 src="{{$actualReservation->owner==null ?: $actualReservation->owner->image}}"
											 class="twPc-avatarImg">
									</a>
									
									<div class="twPc-divUser">
										<div class="twPc-divName">
											<a href="https://is.sh.cvut.cz/users/{{$actualReservation->tenant_uid}}"
											   target="_blank"
											   rel="noopener">{{$actualReservation->ownerName()}}</a>
										</div>
										<span>
                                            	@if($actualReservation->owner==null)
												UID: {{$actualReservation->ownerEmail()}}
											@else
												<a href="mailto:{{$actualReservation->owner->email}}"><span>{{$actualReservation->owner->email}}</span></a>
											@endif
                                        </span>
									</div>
									
									<div class="twPc-divStats">
										<ul class="twPc-Arrange">
											<li class="twPc-ArrangeSizeFit">
												<a href="#"
												   title="{{date('d.m.Y H:i',strtotime($actualReservation->start))}}">
													<span class="twPc-StatLabel twPc-block">Start</span>
													<span class="twPc-StatValue">{{date('d.m.Y H:i',strtotime($actualReservation->start))}}</span>
												</a>
											</li>
											<li class="twPc-ArrangeSizeFit">
												<a href="#"
												   title="{{date('d.m.Y H:i',strtotime($actualReservation->end))}}">
													<span class="twPc-StatLabel twPc-block">End</span>
													<span class="twPc-StatValue">{{date('d.m.Y H:i',strtotime($actualReservation->end))}}</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						
						@else
							<h3 class="text-success">Free</h3>
						@endif
					</div>
				</div>
			</div>
		@endforeach
	</div>

@endsection