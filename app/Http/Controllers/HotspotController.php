<?php

namespace App\Http\Controllers;

use App\Models\HotspotGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotspotController extends Controller
{
    /**
     * Capture variables to session and redirect to register screen
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'mac_address|required',
            'ap' => 'mac_address|required',
        ]);

        if ($validator->fails()) {
            return view('error');
        }

        $request->session()->put('client_mac', $request->get('id'));
        $request->session()->put('ap_mac', $request->get('ap'));

        return redirect('register');
    }
    /**
     * Display registration page
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {

        return view('register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'email' => 'email|required',
            'postcode' => 'string|required',
        ]);

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        // save the record to db

        $validated = $validator->validated();

        $client_mac = $request->session()->get('client_mac');
        $ap_mac = $request->session()->get('ap_mac');

        $user = HotspotGuest::create($validated);
        $user->save();

        if ($user->exists) {
            /**
             ** initialize the UniFi API connection class, log in to the controller and authorise the client
             ** (this example assumes you have already assigned the correct values to the variables used)
             ** specifying the AP speeds up the authorisation and minimises delay for client
             **/

            $controller_user = config('unifi.config.user');
            $controller_password = config('unifi.config.password');
            $controller_url = config('unifi.config.url');
            $site_id = config('unifi.config.site_id');
            $controller_version = config('unifi.config.version');
            $debug = config('unifi.config.debug');

            $unifi_connection = new \UniFi_API\Client($controller_user, $controller_password, $controller_url, $site_id, $controller_version, true);
            $login            = $unifi_connection->login();
            $set_debug_mode   = $unifi_connection->set_debug($debug);

            /**
             ** then we authorize the device for the requested duration
             **/
            $duration = "60";

            $auth_result = $unifi_connection->authorize_guest($client_mac, $duration, null, null, null, $ap_mac);

            if ($auth_result == true) {
                return view('authorised');
            } else {
                return view('error');
            }
        }
    }
}
