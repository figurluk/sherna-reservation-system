<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;

class BadgesController extends Controller
{
    public function index()
    {
        $badges = Badge::paginate(15);

        return view('admin.badges.index', compact(['badges']));
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
