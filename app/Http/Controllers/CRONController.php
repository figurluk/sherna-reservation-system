<?php

namespace App\Http\Controllers;

use App\Models\Reservation;

class CRONController extends Controller
{
    public function controlEnteredReservation()
    {
        $reservations = Reservation::whereNull('entered_at')
            ->whereNull('canceled_at')
            ->where('start', '<=', date('Y-m-d H:i:s', strtotime('+15 minutes')))
            ->where('end', '>=', date('Y-m-d H:i:s'))
            ->get();
        foreach ($reservations as $reservation) {
            $reservation->canceled_at = date('Y-m-d H:i:s');
            $reservation->save();
        }
    }
}
