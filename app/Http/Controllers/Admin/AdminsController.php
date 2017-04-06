<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    /**
     * AdminsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['super_admin']);
    }

    public function index()
    {
        $admins = Admin::paginate(15);

        return view('admin.admins.index', compact(['admins']));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'uid'  => 'required|string|max:255',
            'role' => 'required',
        ]);

        if (($admin = Admin::where('uid', $request->uid)->first()) != null) {
            if ($request->role == 'uzivatel' && $admin->role != 'uzivatel') {
                $admin->delete();
                flash()->success('Admin access successfully removed');
            } else if ($request->role != 'uzivatel') {
                $admin->role = $request->role;
                $admin->save();
                flash()->success('Admin successfully created');
            }
        } else {
            if ($request->role != 'uzivatel') {
                Admin::create($request->all());
                flash()->success('Admin successfully created');
            }
        }

        if (isset($request->redirect) && $request->redirect == 'users')
            return redirect()->action('Admin\UsersController@index');
        else
            return redirect()->action('Admin\AdminsController@index');
    }

    public function delete($id, Request $request)
    {
        $admin = Admin::find($id);
        $admin->delete();

        flash()->success('Admin access successfully removed');

        return redirect()->action('Admin\AdminsController@index');
    }
}
