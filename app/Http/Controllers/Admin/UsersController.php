<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
	/**
	 * AdminsController constructor.
	 */
	public function __construct()
	{
		$this->middleware(['super_admin_oou']);
		$this->middleware(['super_admin'])->only(['ban', 'unban']);
	}
	
	public function index()
	{
		$email = null;
		$name = null;
		$surname = null;
		$conditions = [];
		
		if (Session::get('admin_users_filter_email') != null) {
			$conditions['email'] = Session::get('admin_users_filter_email');
			$email = Session::get('admin_users_filter_email');
		}
		if (Session::get('admin_users_filter_name') != null) {
			$conditions['name'] = Session::get('admin_users_filter_name');
			$name = Session::get('admin_users_filter_name');
		}
		if (Session::get('admin_users_filter_surname') != null) {
			$conditions['surname'] = Session::get('admin_users_filter_surname');
			$surname = Session::get('admin_users_filter_surname');
		}
		
		$users = User::where(function ( $q ) use ( $conditions ) {
			foreach ($conditions as $key => $value) {
				if ($key == 'email') {
					$q->where('email', 'LIKE', '%' . $value . '%');
				} elseif ($key == 'name') {
					$q->where('name', 'LIKE', '%' . $value . '%');
				} elseif ($key == 'surname') {
					$q->where('surname', 'LIKE', '%' . $value . '%');
				}
			}
		})->orderBy('surname')->paginate(20);
		
		return view('admin.users.index', compact('users', 'name', 'surname', 'email'));
	}
	
	
	public function filterEmail( Request $request )
	{
		Session::put('admin_users_filter_email', $request->email);
		
		return redirect()->action('Admin\UsersController@index');
	}
	
	
	public function filterName( Request $request )
	{
		Session::put('admin_users_filter_name', $request->name);
		
		return redirect()->action('Admin\UsersController@index');
	}
	
	
	public function filterSurname( Request $request )
	{
		Session::put('admin_users_filter_surname', $request->surname);
		
		return redirect()->action('Admin\UsersController@index');
	}
	
	public function editBadges( $id )
	{
		$user = User::findOrFail($id);
		
		return view('admin.users.badges-edit', compact('user'));
	}
	
	public function storeBadge( Request $request, $userID )
	{
		$user = User::findOrFail($userID);
		$badge = Badge::findOrFail($request->badge_id);
		
		$user->badges()->syncWithoutDetaching($request->badge_id);
		
		flash()->success('Badge ' . $badge->name . ' successfully added to user: ' . $user->email . '.');
		
		return redirect()->action('Admin\UsersController@editBadges', $user->id);
	}
	
	public function removeBadge( $badgeID, $userID )
	{
		$user = User::findOrFail($userID);
		$badge = Badge::findOrFail($badgeID);
		
		$user->badges()->detach($badgeID);
		
		flash()->success('Badge ' . $badge->name . ' successfully removed from user: ' . $user->email . '.');
		
		return redirect()->action('Admin\UsersController@editBadges', $user->id);
	}
	
	public function ban( $userID )
	{
		$user = User::findOrFail($userID);
		
		$user->banned = true;
		$user->save();
		
		flash()->success('User ' . $user->email . ' successfully banned.');
		
		return redirect()->action('Admin\UsersController@index');
	}
	
	public function unban( $userID )
	{
		$user = User::findOrFail($userID);
		
		$user->banned = false;
		$user->save();
		
		flash()->success('User ' . $user->email . ' successfully banned.');
		
		return redirect()->action('Admin\UsersController@index');
	}
}
