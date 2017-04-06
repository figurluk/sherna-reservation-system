<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Page;
use App\Models\Reservation;
use App\Models\User;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\UriFactory;
use OAuth\Common\Storage\Session;
use OAuth\ServiceFactory;

class ClientController extends Controller
{
    public function index()
    {
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

    public function postUserData()
    {
        if (!\Auth::check()) return response('', 401);

        return \Auth::user()->toJson();
    }

    public function postCreateEvent()
    {

    }

    public function postEvents()
    {

        $reservations = Reservation::get();

    }
}
