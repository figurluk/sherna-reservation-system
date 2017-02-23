<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\LocationStatus;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function index()
    {
        $locations = Location::paginate(15);
        $locationStatuses = LocationStatus::get();

        return view('admin.locations.index', compact(['locations', 'locationStatuses']));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function edit($id)
    {
        $location = Location::find($id);

        return view('admin.locations.edit', compact(['location']));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'               => 'required|string|max:255',
            'location_status_id' => 'required',
        ]);

        Location::create($request->all());
        flash()->success('Location successfully created');

        return redirect()->action('Admin\LocationsController@index');
    }


    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name'               => 'required|string|max:255',
            'location_status_id' => 'required',
        ]);

        $game = Location::find($id);
        $game->update($request->all());
        flash()->success('Location successfully updated');

        return redirect()->action('Admin\LocationsController@index');
    }

    public function delete($id, Request $request)
    {
        $game = Location::find($id);
        $game->delete();
        flash()->success('Location successfully deleted');

        return redirect()->action('Admin\LocationsController@index');
    }

    public function createStatus()
    {
        return view('admin.locations.status.create');
    }

    public function editStatus($id)
    {
        $locationStatus = LocationStatus::find($id);

        return view('admin.locations.status.edit', compact(['locationStatus']));
    }

    public function storeStatus(Request $request)
    {
        $this->validate($request, [
            'name'               => 'required|string|max:255',
            'opened' => 'required',
        ]);

        LocationStatus::create($request->all());
        flash()->success('Location status successfully created');

        return redirect()->action('Admin\LocationsController@index');
    }


    public function updateStatus($id, Request $request)
    {
        $this->validate($request, [
            'name'               => 'required|string|max:255',
            'opened' => 'required',
        ]);

        $game = LocationStatus::find($id);
        $game->update($request->all());
        flash()->success('Location status successfully updated');

        return redirect()->action('Admin\LocationsController@index');
    }
}