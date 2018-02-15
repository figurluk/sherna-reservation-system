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
		
		return view('admin.badges.index', compact('badges'));
	}
	
	public function create()
	{
		return view('admin.badges.create');
	}
	
	public function edit( $id )
	{
		$badge = Badge::findOrFail($id);
		
		return view('admin.badges.edit', compact('badge'));
	}
	
	public function store( Request $request )
	{
		$this->validate($request, ['name' => 'required|string|max:255']);
		
		Badge::create([
			'name'   => $request->name,
			'system' => $request->system,
		]);
		
		flash()->success('Badge successfully created.');
		
		return redirect()->action('Admin\BadgesController@index');
	}
	
	
	public function update( $id, Request $request )
	{
		$this->validate($request, ['name' => 'required|string|max:255']);
		
		$badge = Badge::findOrFail($id);
		$badge->name = $request->name;
		$badge->system = $request->system;
		$badge->save();
		
		flash()->success('Badge successfully updated.');
		
		return redirect()->action('Admin\BadgesController@index');
		
	}
	
	public function delete( $id, Request $request )
	{
		$badge = Badge::findOrFail($id);
		$badge->users()->sync([]);
		
		$badge->delete();
		
		flash()->success('Badge successfully deleted.');
		
		return redirect()->action('Admin\BadgesController@index');
	}
}
