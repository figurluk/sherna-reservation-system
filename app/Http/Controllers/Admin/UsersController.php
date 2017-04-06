<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('surname')->paginate(20);

        return view('admin.users.index', compact(['users']));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit($id)
    {
        return view('admin.users.edit');
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
