<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConsolesController extends Controller
{
    public function index()
    {
        return view('admin.consoles.index');
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function edit($id)
    {

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
