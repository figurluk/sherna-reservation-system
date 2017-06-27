<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Location;
use App\Models\Page;
use App\Models\Reservation;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\UriFactory;
use OAuth\Common\Storage\Session;
use OAuth\ServiceFactory;

class ClientController extends Controller
{
    public function index()
    {
        if (env('APP_ENV') == 'local' && !Auth::check())
            \Auth::loginUsingId(User::first()->id);
        $page = Page::whereCode('domu')->first();

        return view('client.index', compact(['page']));
    }

    public function show($code)
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
//        dd($url, $url->getAbsoluteUri());
//        dd($this->unparse_url($url));

        return redirect()->to($url->getAbsoluteUri());
//        return header('Location: '.$url);
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
        $url = $currentUri->getRelativeUri();

//        return redirect()->to($url->getAbsoluteUri());
//        header('Location: '.$url);
        return redirect()->action('Client\ClientController@index');
    }

    /**
     * @param $result
     */
    private function controlLoginUser($result)
    {
        if (User::where('uid', $result['id'])->first() == null) {
            $user = User::create([
                'uid'      => $result['id'],
                'name'     => $result['first_name'],
                'surname'  => $result['surname'],
                'email'    => $result['email'],
                'password' => uniqid(),
            ]);

            if (in_array($result['id'], explode(',', env('SUPER_ADMINS'))) || Admin::where('uid', $result['id'])->where('role', 'super_admin')->exists()) {
                $user->role = 'super_admin';
                $user->save();
            } else if (Admin::where('uid', $result['id'])->where('role', 'admin')->exists()) {
                $user->role = 'admin';
                $user->save();
            }

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

            if (in_array($result['id'], explode(',', env('SUPER_ADMINS'))) || Admin::where('uid', $result['id'])->where('role', 'super_admin')->exists()) {
                $user->role = 'super_admin';
            } else if (Admin::where('uid', $result['id'])->where('role', 'admin')->exists()) {
                $user->role = 'admin';
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

    public function changeLang($langCode)
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
                'fullname' => $result['first_name']." ".$result['surname'],
                'photo'    => $result['photo_file_small'],
            ];

            $this->controlLoginUser($result);

//            $url = $currentUri->getRelativeUri();

//            header('Location: '.$url);
            return redirect()->action('Client\ClientController@index');
        }
    }

    public function postUserData(Request $request)
    {
        if (!\Auth::check()) return response('Prihlas sa', 401);

        return \Auth::user()->toJson();
    }

    public function postCreateEvent(Request $request)
    {
        $date = date('Y-m-d', strtotime($request->start));
        $reservationExist = Reservation::where('day', $date)
            ->where('location_id', '=', $request->location)
            ->where(function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('end', '>', $request->start)
                        ->where('start', '<', $request->start);
                })->orWhere(function ($query) use ($request) {
                    $query->where('end', '>', $request->end)
                        ->where('start', '<', $request->end);
                })->orWhere(function ($query) use ($request) {
                    $query->where('end', '>=', $request->end)
                        ->where('start', '<=', $request->start);
                });
            })
            ->exists();

        $location = Location::find($request->location);
        if (!$reservationExist && $location->isOpened()) {
            $reservation = Reservation::create([
                'tenant_uid'  => $request->userUID,
                'location_id' => $request->location,
                'day'         => $date,
                'start'       => date('H:i:s', strtotime($request->start)),
                'end'         => date('H:i:s', strtotime($request->end)),
                'note'        => $request->note
            ]);

            return response(['id'       => $reservation->id,
                             'editable' => strtotime(date('Y-m-d H:i:s', strtotime(config('calendar.duration-for-edit')))) < strtotime($request->start)]);
        } else {
            if (!$location->isOpened()) {
                return response('Tato miestnost je zatvorena.', 401);
            } else {
                return response('Rezervacia uz v danom case exisutuje.', 401);
            }
        }
    }

    public function postUpdateEvent(Request $request)
    {
        $date = date('Y-m-d', strtotime($request->start));
        $oldReservation = Reservation::find($request->reservation_id);
        $reservationExist = Reservation::where('id', '!=', $request->reservation_id)
            ->where('location_id', '=', $oldReservation->location_id)
            ->where('day', $date)
            ->where(function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('end', '>', $request->start)
                        ->where('start', '<', $request->start);
                })->orWhere(function ($query) use ($request) {
                    $query->where('end', '>', $request->end)
                        ->where('start', '<', $request->end);
                })->orWhere(function ($query) use ($request) {
                    $query->where('end', '>=', $request->end)
                        ->where('start', '<=', $request->start);
                });
            })
            ->exists();

        $location = Location::find($oldReservation->location_id);
        if (!$reservationExist && $location->isOpened()) {
            $reservation = Reservation::create([
                'tenant_uid'  => $oldReservation->tenant_uid,
                'location_id' => $oldReservation->location_id,
                'day'         => $date,
                'start'       => date('H:i:s', strtotime($request->start)),
                'end'         => date('H:i:s', strtotime($request->end)),
                'note'        => $oldReservation->note
            ]);

            $oldReservation->delete();

            return response(['id'       => $reservation->id,
                             'editable' => strtotime(date('Y-m-d H:i:s', strtotime(config('calendar.duration-for-edit')))) < strtotime($request->start)]);
        } else {

            if (!$location->isOpened()) {
                return response('Tato miestnost je zatvorena.', 401);
            } else {
                return response('Rezervacia uz v danom case exisutuje.', 401);
            }
        }
    }

    public function postDeleteEvent(Request $request)
    {
        $oldReservation = Reservation::find($request->reservation_id);
        $oldReservation->delete();

        return response('ok');
    }

    public function postEvents(Request $request)
    {
        $reservations = Reservation::where('location_id', $request->location)->get(['id', 'start', 'end', 'note', 'tenant_uid', 'day'])->toArray();
        foreach ($reservations as $key => $reservation) {
            $owner = User::where('uid', $reservation['tenant_uid'])->first();
            $reservations[ $key ]['title'] = 'Rezervace pro: '.$owner->name.' '.$owner->surname;
            $reservations[ $key ]['start'] = $reservations[ $key ]['day'].' '.$reservations[ $key ]['start'];
            $reservations[ $key ]['end'] = $reservations[ $key ]['day'].' '.$reservations[ $key ]['end'];

            if (Auth::check() && $reservation['tenant_uid'] == Auth::user()->uid) {
                $reservations[ $key ]['editable'] = date('Y-m-d H:i:s', strtotime(config('calendar.duration-for-edit'))) < $reservation['day'].' '.$reservation['start'];
                $reservations[ $key ]['backgroundColor'] = config('calendar.my-reservation.background-color');
                $reservations[ $key ]['textColor'] = config('calendar.my-reservation.color');
                $reservations[ $key ]['borderColor'] = config('calendar.my-reservation.border-color');
            }
        }

        return $reservations;
    }
}
