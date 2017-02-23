<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\UriFactory;
use OAuth\Common\Storage\Session;
use OAuth\ServiceFactory;

class ClientController extends Controller
{
    public function index()
    {
        list($currentUri, $service) = $this->getISService();

        if (!empty($_GET['code'])) {
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

            $url = $currentUri->getRelativeUri();

            header('Location: ' . $url);
        }

        return view('welcome');
    }

    public function getAuthorize()
    {
        /**
         * Create a new instance of the URI class with the current URI, stripping the query string
         */
        list($currentUri, $service) = $this->getISService();

        $url = $service->getAuthorizationUri();

        header('Location: ' . $url);
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

        header('Location: ' . $url);
    }

    /**
     * @param $result
     */
    private function controlLoginUser($result)
    {
        if (User::where('uid', $result['id'])->first() == null) {
            User::create([
                'uid'     => $result['id'],
                'name'    => $result['first_name'],
                'surname' => $result['surname'],
                'email'   => $result['email']
            ]);
            \Auth::attempt(['uid' => $result['id']]);
        } else {
            \Auth::attempt(['uid' => $result['id']]);

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
            $currentUri->getAbsoluteUri() //callback url
        );

        // Session storage
        $storage = new Session();

        // Instantiate the service using the credentials, http client and storage mechanism for the token
        $serviceFactory = new ServiceFactory();
        $service = $serviceFactory->createService('IS', $credentials, $storage);

        return [$currentUri, $service];
    }
}
