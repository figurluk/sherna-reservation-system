<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Location;
use App\Models\Page;
use App\Models\Reservation;
use App\Models\User;
use Auth;
use App\Classes\ICS;
use Illuminate\Http\Request;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\UriFactory;
use OAuth\Common\Storage\Session;
use OAuth\ServiceFactory;

class ClientController extends Controller
{
	/**
	 * ClientController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth', ['only' => 'getReservations']);
	}
	
	public function index()
	{
		if (env('APP_ENV') == 'local' && !Auth::check())
			\Auth::loginUsingId(User::first()->id);
		$page = Page::whereCode('domu')->first();
		
		return view('client.index', compact(['page']));
	}
	
	public function show( $code )
	{
		$page = Page::whereCode($code)->first();
		if ($page == null || !$page->public) return redirect()->action('Client\ClientController@index');
		
		return view('client.show', compact(['page']));
	}
	
	public function getAuthorize()
	{
		/**
		 * Create a new instance of the URI class with the current URI, stripping the query string
		 */
		list($currentUri, $service) = $this->getISService();
		
		$url = $service->getAuthorizationUri();
		
		return redirect()->to($url->getAbsoluteUri());
	}
	
	public function getLogout()
	{
		/**
		 * Create a new instance of the URI class with the current URI, stripping the query string
		 */
		$uriFactory = new UriFactory();
		$currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
		$currentUri->setQuery('');
		
		// Session storage
		$storage = new Session();
		
		$storage->clearToken('IS');
		
		\Auth::logout();
		
		return redirect()->action('Client\ClientController@index');
	}
	
	/**
	 * @param $result
	 */
	private function controlLoginUser( $result )
	{
		if (User::where('uid', $result['id'])->first() == null) {
			User::create([
				'uid'      => $result['id'],
				'name'     => $result['first_name'],
				'surname'  => $result['surname'],
				'email'    => $result['email'],
				'image'    => $result['photo_file_small'],
				'password' => uniqid(),
			]);
			
			\Auth::attempt(['uid' => $result['id'], 'email' => $result['email']]);
		} else {
			\Auth::attempt(['uid' => $result['id'], 'email' => $result['email']]);
			
			$user = \Auth::user();
			if ($user->name != $result['first_name']) {
				$user->name = $result['first_name'];
			}
			if ($user->surname != $result['surname']) {
				$user->surname = $result['surname'];
			}
			if ($user->email != $result['email']) {
				$user->email = $result['email'];
			}
			if ($user->image != $result['photo_file_small']) {
				$user->image = $result['photo_file_small'];
			}
			
			$user->save();
		}
	}
	
	/**
	 * @return array
	 */
	private function getISService()
	{
		/**
		 * Create a new instance of the URI class with the current URI, stripping the query string
		 */
		$uriFactory = new UriFactory();
		$currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
		$currentUri->setQuery('');
		
		// Setup the credentials for the requests
		$credentials = new Credentials(
			env('IS_OAUTH_ID'), //Application ID
			env('IS_OAUTH_SECRET'), // SECRET
			action('Client\ClientController@oAuthCallback') //callback url
		);
		
		// Session storage
		$storage = new Session();
		
		// Instantiate the service using the credentials, http client and storage mechanism for the token
		$serviceFactory = new ServiceFactory();
		$service = $serviceFactory->createService('IS', $credentials, $storage);
		
		return [$currentUri, $service];
	}
	
	public function changeLang( $langCode )
	{
		if ($langCode == 'sk' || $langCode == 'cz' || $langCode == 'en') {
			\Session::put('lang', $langCode);
		}
		
		return redirect()->back();
	}
	
	public function oAuthCallback()
	{
		if (!empty($_GET['code'])) {
			list($currentUri, $service) = $this->getISService();
			// This was a callback request from is, get the token
			$service->requestAccessToken($_GET['code']);
			
			// Get UID, fullname and photo
			$result = json_decode($service->request('users/me.json'), true);
			$_SESSION['user'] = [
				'uid'      => $result['id'],
				'fullname' => $result['first_name'] . " " . $result['surname'],
				'photo'    => $result['photo_file_small'],
			];
			
			$this->controlLoginUser($result);
			
			return redirect()->action('Client\ClientController@index');
		}
	}
	
	public function postUserData( Request $request )
	{
		if (!\Auth::check()) return response('Log in', 401);
		
		return \Auth::user()->toJson();
	}
	
	public function postCreateEvent( Request $request )
	{
		if (Auth::user()->reservations()->futureActiveReservations()->count() > 0) {
			return response(['state' => 'failed', 'title' => trans('reservation-modal.failed.title'), 'text' => trans('general.future_reservations')], 401);
		}
		
		$this->validate($request,
			[
				'start'    => 'required|date|before:end',
				'end'      => 'required|date',
				'location' => 'required',
			]
		);
		
		$startTime = date('Y-m-d H:i:s', strtotime($request->start));
		$endTime = date('Y-m-d H:i:s', strtotime($request->end));
		
		$location = Location::find($request->location);
		
		if (!$location->isOpened()) {
			return response(['state' => 'failed', 'title' => trans('reservation-modal.failed.title'), 'text' => trans('reservation-modal.failed.closed.text')], 401);
		}
		
		$reservationExist = Reservation::whereNull('canceled_at')
			->where('location_id', '=', $request->location)
			->where(function ( $q ) use ( $request, $startTime, $endTime ) {
				$q->where(function ( $query ) use ( $request, $startTime, $endTime ) {
					$query->where('end', '>', $startTime)
						->where('start', '<', $startTime);
				})->orWhere(function ( $query ) use ( $request, $startTime, $endTime ) {
					$query->where('end', '>', $endTime)
						->where('start', '<', $endTime);
				})->orWhere(function ( $query ) use ( $request, $startTime, $endTime ) {
					$query->where('end', '>=', $endTime)
						->where('start', '<=', $startTime);
				})->orWhere(function ( $query ) use ( $request, $startTime, $endTime ) {
					$query->where('end', '<=', $endTime)
						->where('start', '>=', $startTime);
				});
			})
			->exists();
		
		$parallelReservationExist = Reservation::whereNull('canceled_at')
			->where('location_id', '!=', $request->location)
			->where('tenant_uid', '=', $request->userUID)
			->where(function ( $q ) use ( $request, $startTime, $endTime ) {
				$q->where(function ( $query ) use ( $request, $startTime, $endTime ) {
					$query->where('end', '>', $startTime)
						->where('start', '<', $startTime);
				})->orWhere(function ( $query ) use ( $request, $startTime, $endTime ) {
					$query->where('end', '>', $endTime)
						->where('start', '<', $endTime);
				})->orWhere(function ( $query ) use ( $request, $startTime, $endTime ) {
					$query->where('end', '>=', $endTime)
						->where('start', '<=', $startTime);
				})->orWhere(function ( $query ) use ( $request, $startTime, $endTime ) {
					$query->where('end', '<=', $endTime)
						->where('start', '>=', $startTime);
				});
			})
			->exists();
		
		if ($parallelReservationExist) {
			return response(['state' => 'failed', 'title' => trans('reservation-modal.failed.title'), 'text' => trans('reservation-modal.failed.parallel.text')], 401);
		}
		
		if (!$reservationExist && $location->isOpened()) {
			$reservation = Reservation::create([
				'tenant_uid'  => $request->userUID,
				'location_id' => $request->location,
				'start'       => $startTime,
				'end'         => $endTime,
				'note'        => $request->note,
			]);
			
			return response(['id'       => $reservation->id,
							 'editable' => false]);
		} else {
			return response(['state' => 'failed', 'title' => trans('reservation-modal.failed.title'), 'text' => trans('reservation-modal.failed.exist.text')], 401);
		}
	}
	
	public function postUpdateEvent( Request $request )
	{
		$oldReservation = Reservation::find($request->reservation_id);
		$reservationExist = Reservation::where('id', '!=', $request->reservation_id)
			->whereNull('canceled_at')
			->where('location_id', '=', $oldReservation->location_id)
			->where(function ( $q ) use ( $request, $oldReservation ) {
				$q->where(function ( $query ) use ( $request, $oldReservation ) {
					$query->where('end', '>', $oldReservation->start)
						->where('start', '<', $oldReservation->start);
				})->orWhere(function ( $query ) use ( $request ) {
					$query->where('end', '>', $request->end)
						->where('start', '<', $request->end);
				})->orWhere(function ( $query ) use ( $request, $oldReservation ) {
					$query->where('end', '>=', $request->end)
						->where('start', '<=', $oldReservation->start);
				});
			})
			->exists();
		
		$location = Location::find($oldReservation->location_id);
		if (!$reservationExist && $location->isOpened()) {
			
			$oldReservation->end = date('Y-m-d H:i:s', strtotime($request->end));
			$oldReservation->save();
			
			return response(['id'       => $oldReservation->id, 'end' => date('d.m.Y H:i', strtotime($oldReservation->end)),
							 'editable' => date('Y-m-d H:i:s', strtotime($oldReservation->start, strtotime('- ' . config('calendar.duration-for-edit') . ' minutes'))) > date('Y-m-d H:i:s') ? true : false]);
		} else {
			
			if (!$location->isOpened()) {
				return response(['title' => trans('reservation-modal.failed.title'), 'text' => 'Tato miestnost je zatvorena.'], 401);
			} else {
				return response(['title' => trans('reservation-modal.failed.title'), 'text' => trans('reservation-modal.failed.exist.text')], 401);
			}
		}
	}
	
	public function postDeleteEvent( Request $request )
	{
		$oldReservation = Reservation::find($request->reservation_id);
		if ($oldReservation != null) {
			$oldReservation->delete();
		}
		
		return response('ok');
	}
	
	public function getDeleteEvent( $event )
	{
		$oldReservation = Reservation::find($event);
		$oldReservation->delete();
		
		flash()->success(trans('reservations.success_deleted'));
		
		return redirect()->action('Client\ClientController@getReservations');
	}
	
	public function postEvents( Request $request )
	{
		$reservations = Reservation::where('location_id', $request->location)->get(['id', 'start', 'end', 'note', 'tenant_uid'])->toArray();
		foreach ($reservations as $key => $reservation) {
			$owner = User::where('uid', $reservation['tenant_uid'])->first();
			if ($owner == null) {
				$reservations[$key]['title'] = trans('reservations.reservation_for') . $reservation['tenant_uid'];
			} else {
				$reservations[$key]['title'] = trans('reservations.reservation_for') . $owner->name . ' ' . $owner->surname;
			}
			
			
			if (Auth::check() && $reservation['tenant_uid'] == Auth::user()->uid) {
				$reservations[$key]['editable'] = date('Y-m-d H:i:s', strtotime($reservation['start'], strtotime('- ' . config('calendar.duration-for-edit') . ' minutes'))) > date('Y-m-d H:i:s') ? true : false;
				$reservations[$key]['backgroundColor'] = config('calendar.my-reservation.background-color');
				$reservations[$key]['textColor'] = config('calendar.my-reservation.color');
				$reservations[$key]['borderColor'] = config('calendar.my-reservation.border-color');
			} else {
				$reservations[$key]['textColor'] = '#fff';
				$reservations[$key]['backgroundColor'] = '#4285f4';
			}
		}
		
		return $reservations;
	}
	
	public function postConsoles( Request $request )
	{
		$consoles = Location::find($request->location)->consoles;
		
		if (count($consoles) > 0) {
			return view('client.consoles', compact('consoles'))->render();
		} else {
			return '0';
		}
	}
	
	public function getReservations()
	{
		$activeReservations = Auth::user()->reservations()->activeReservation()->get();
		$reservations = Auth::user()->reservations()->orderBy('start', 'desc')->paginate(10);
		
		return view('client.reservations', compact('reservations', 'activeReservations'));
	}
	
	public function getReservationICS( $reservationID )
	{
		$reservation = Reservation::findOrFail($reservationID);
		
		$ics = new ICS([
			'location'    => $reservation->location->name,
			'description' => trans('reservations.reservation_for') . $reservation->owner->name . ' ' . $reservation->owner->surname,
			'dtstart'     => date('Y-n-j g:iA', strtotime($reservation->start)),
			'dtend'       => date('Y-n-j g:iA', strtotime($reservation->end)),
			'summary'     => 'SHerna',
			'url'         => action('Client\ClientController@getReservations'),
		]);
		
		return response($ics->to_string())->withHeaders([
			'Content-Type'        => 'text/calendar; charset=utf-8',
			'Content-Disposition' => 'attachment; filename=sherna_reservation.ics',
		]);
	}
	
	public function getBadges()
	{
		return view('client.badges');
	}
	
	public function postEvent( Request $request )
	{
		$reservation = Reservation::find($request->reservationID);
		
		if ($reservation == null)
			return response('bad request', 404);
		
		return $reservation->toJson();
	}
}
