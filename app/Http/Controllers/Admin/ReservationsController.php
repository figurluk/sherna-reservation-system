<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index()
    {
        return view('admin.reservations.index');
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
