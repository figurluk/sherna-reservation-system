<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
	public function index()
	{
		$users = User::orderBy('surname')->paginate(20);
		
		return view('admin.users.index', compact(['users']));
	}
	
	public function editBadges( $id )
	{
		$user = User::findOrFail($id);
		
		return view('admin.users.badges-edit',compact('user'));
	}
	
	public function storeBadge(Request $request, $userID )
	{
		$user = User::findOrFail($userID);
		$badge = Badge::findOrFail($request->badge_id);
		
		$user->badges()->syncWithoutDetaching($request->badge_id);
		
		flash()->success('Badge '.$badge->name.' successfully added to user: '.$user->email.'.');
		
		return redirect()->action('Admin\UsersController@editBadges',$user->id);
	}
	
	public function removeBadge( $badgeID, $userID )
	{
		$user = User::findOrFail($userID);
		$badge = Badge::findOrFail($badgeID);
		
		$user->badges()->detach($badgeID);
		
		flash()->success('Badge '.$badge->name.' successfully removed from user: '.$user->email.'.');
		
		return redirect()->action('Admin\UsersController@editBadges',$user->id);
	}
}
