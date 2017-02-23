<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BadgesController extends Controller
{
    public function index()
    {
        return view('admin.badges.index');
    }

    public function create()
    {
        return view('admin.badges.create');
    }

    public function edit($id)
    {
        return view('admin.badges.edit');
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
