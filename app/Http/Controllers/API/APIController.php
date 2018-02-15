<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 03/07/17
 * Time: 20:15
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class APIController extends Controller
{
	
	public function checkReservation( Request $request )
	{
		\Log::info(json_encode($request->all()));
		
		$this->validate($request, [
			'device_id' => 'required',
			'room_id'   => 'required',
			'uid'       => 'required',
		]);
		
		$user = User::where('uid', $request->uid)->first();
		if (( $user != null && $user->isAdmin() ) || ( in_array($request->uid, explode(',', env('SUPER_ADMINS'))) ) || Admin::where('uid', $request->uid)->exists()) {
			return response('true');
		}
		
		$location = Location::where('location_uid', $request->room_id)->where('reader_uid', $request->device_id)->first();
		
		if ($location == null) {
			return response('false');
		}
		
		$accessStartTime = date('Y-m-d H:i:s', strtotime('+' . config('calendar.access_to_location') . ' minutes'));
		$accessEndTime = date('Y-m-d H:i:s', strtotime('-' . config('calendar.access_to_location') . ' minutes'));
		
		$result = Reservation::where('location_id', $location->id)
			->where('tenant_uid', $request->uid)
			->where('start', '<=', $accessStartTime)
			->whereNull('canceled_at')
			->where('end', '>=', $accessEndTime)->first();
		
		if ($result == null) {
			return response('false');
		}
		
		$result->entered_at = date('Y-m-d H:i:s');
		$result->save();
		
		return response('true');
	}
	
}