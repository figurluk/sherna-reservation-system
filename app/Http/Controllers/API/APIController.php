<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 03/07/17
 * Time: 20:15
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Reservation;
use Illuminate\Http\Request;

class APIController extends Controller
{
	
	public function checkReservation(Request $request)
	{
		\Log::info(json_encode($request->all()));
		
		$this->validate($request, [
		
		]);
		
		$location = Location::where('location_uid', $request->room_id)->where('reader_uid', $request->device_id)->first();
		
		$accessStartTime = date('Y-m-d H:i:s', strtotime('+'.config('calendar.access_to_location').' minutes'));
		$accessEndTime = date('Y-m-d H:i:s', strtotime('-'.config('calendar.access_to_location').' minutes'));
		
		$result = Reservation::where('location_id', $location->id)
			->where('tenant_uid', $request->uid)
			->where('start', '<=', $accessStartTime)
			->whereNull('canceled_at')
			->where('end', '>=', $accessEndTime)->first();
		
		if ($result==null) {
			return response('false');
		}
		
		$result->entered_at = date('Y-m-d H:i:s');
		$result->save();
		
		return response('true');
	}
	
}