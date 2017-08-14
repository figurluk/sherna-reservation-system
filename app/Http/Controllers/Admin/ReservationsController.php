<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index()
    {
        $reservations = Reservation::orderBy('start','desc')->paginate(15);

        return view('admin.reservations.index', compact(['reservations']));
    }

    public function create()
    {
        return view('admin.reservations.create');
    }

    public function edit($id)
    {
        return view('admin.reservations.edit');
    }

    public function store(Request $request)
    {

    }


    public function update($id, Request $request)
    {

    }

    public function delete($id, Request $request)
    {

    }
}
