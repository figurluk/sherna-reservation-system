<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function index()
    {
        return view('admin.contests.index');
    }

    public function create()
    {
        return view('admin.contests.create');
    }

    public function edit($id)
    {
        return view('admin.contests.edit');
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
