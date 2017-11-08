<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
	public function index()
	{
		$reservations = Reservation::orderBy('start', 'desc')->paginate(15);
		
		return view('admin.reservations.index', compact('reservations'));
	}
	
	public function create()
	{
		return view('admin.reservations.create');
	}
	
	public function edit( $id )
	{
		$reservation = Reservation::findOrFail($id);
		
		return view('admin.reservations.edit', compact('reservation'));
	}
	
	public function store( Request $request )
	{
		$this->validate($request,
			[
				'from_date' => 'required|date|before:to_date',
				'to_date'   => 'required|date',
				'location'  => 'required',
			]
		);
		
		$reservationExist = Reservation::whereNull('canceled_at')
			->where('location_id', '=', $request->location)
			->where(function ( $q ) use ( $request ) {
				$q->where(function ( $query ) use ( $request ) {
					$query->where('end', '>', date('Y-m-d H:i:s', strtotime($request->from_date)))
						->where('start', '<', date('Y-m-d H:i:s', strtotime($request->from_date)));
				})->orWhere(function ( $query ) use ( $request ) {
					$query->where('end', '>', date('Y-m-d H:i:s', strtotime($request->to_date)))
						->where('start', '<', date('Y-m-d H:i:s', strtotime($request->to_date)));
				})->orWhere(function ( $query ) use ( $request ) {
					$query->where('end', '>=', date('Y-m-d H:i:s', strtotime($request->to_date)))
						->where('start', '<=', date('Y-m-d H:i:s', strtotime($request->from_date)));
				})->orWhere(function ( $query ) use ( $request ) {
					$query->where('end', '<=', date('Y-m-d H:i:s', strtotime($request->to_date)))
						->where('start', '>=', date('Y-m-d H:i:s', strtotime($request->from_date)));
				});
			})
			->exists();
		
		
		$location = Location::find($request->location);
		if (!$reservationExist && $location->isOpened()) {
			Reservation::create([
				'tenant_uid'  => \Auth::user()->uid,
				'location_id' => $request->location,
				'start'       => date('Y-m-d H:i:s', strtotime($request->from_date)),
				'end'         => date('Y-m-d H:i:s', strtotime($request->to_date)),
				'note'        => $request->note,
			]);
			
			flash()->success('Reservation successfully created.');
			
			return redirect()->action('Admin\ReservationsController@index');
		} else {
			if (!$location->isOpened()) {
				flash()->error('This location is closed.');
				
				return redirect()->back()->withInput($request->all());
			} else {
				flash()->error('Reservation in this time exist.');
				
				return redirect()->back()->withInput($request->all());
			}
		}
	}
	
	
	public function update( $id, Request $request )
	{
		$this->validate($request,
			[
				'from_date' => 'required|date|before:to_date',
				'to_date'   => 'required|date',
				'location'  => 'required',
			]
		);
		
		$reservationExist = Reservation::whereNull('canceled_at')
			->where('id', '!=', $id)
			->where('location_id', '=', $request->location)
			->where(function ( $q ) use ( $request ) {
				$q->where(function ( $query ) use ( $request ) {
					$query->where('end', '>', date('Y-m-d H:i:s', strtotime($request->from_date)))
						->where('start', '<', date('Y-m-d H:i:s', strtotime($request->from_date)));
				})->orWhere(function ( $query ) use ( $request ) {
					$query->where('end', '>', date('Y-m-d H:i:s', strtotime($request->to_date)))
						->where('start', '<', date('Y-m-d H:i:s', strtotime($request->to_date)));
				})->orWhere(function ( $query ) use ( $request ) {
					$query->where('end', '>=', date('Y-m-d H:i:s', strtotime($request->to_date)))
						->where('start', '<=', date('Y-m-d H:i:s', strtotime($request->from_date)));
				})->orWhere(function ( $query ) use ( $request ) {
					$query->where('end', '<=', date('Y-m-d H:i:s', strtotime($request->to_date)))
						->where('start', '>=', date('Y-m-d H:i:s', strtotime($request->from_date)));
				});
			})
			->exists();
		
		
		$location = Location::find($request->location);
		if (!$reservationExist && $location->isOpened()) {
			
			$reservation = Reservation::findOrFail($id);
			$reservation->location_id = $request->location;
			$reservation->start = date('Y-m-d H:i:s', strtotime($request->from_date));
			$reservation->end = date('Y-m-d H:i:s', strtotime($request->to_date));
			$reservation->note = $request->note;
			
			$reservation->save();
			
			flash()->success('Reservation successfully updated.');
			
			return redirect()->action('Admin\ReservationsController@index');
		} else {
			if (!$location->isOpened()) {
				flash()->error('This location is closed.');
				
				return redirect()->back()->withInput($request->all());
			} else {
				flash()->error('Reservation in this time exist.');
				
				return redirect()->back()->withInput($request->all());
			}
		}
	}
	
	public function delete( $id )
	{
		$reservation = Reservation::findOrFail($id);
		$reservation->delete();
		
		flash()->success('Reservation successfully deleted.');
		
		return redirect()->action('Admin\ReservationsController@index');
	}
}
