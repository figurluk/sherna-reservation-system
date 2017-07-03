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
        $this->validate($request, [

        ]);

        $location = Location::where('location_uid', $request->location_uid)->where('reader_uid', $request->reader_uid)->first();

        $accessDay = date('Y-m-d');
        $accessStartTime = date('H:i:s', strtotime('+'.config('calendar.access_to_location').' minutes'));
        $accessEndTime = date('H:i:s', strtotime('-'.config('calendar.access_to_location').' minutes'));

        $result = Reservation::where('location_id', $location->id)
            ->where('tenant_uid', $request->user_uid)
            ->where('day', $accessDay)
            ->where('start', '<=', $accessStartTime)
            ->where('end', '>=', $accessEndTime)->exists();

        return response(($result) ? 'true' : 'false');
    }

}