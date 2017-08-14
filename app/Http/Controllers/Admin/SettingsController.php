<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $this->changeConfig($request->except('_token', 'name'));

        return redirect()->action('Admin\SettingsController@index');
    }

    public function changeConfig($data = [])
    {
        if (count($data) > 0) {

            $config = require(base_path().'/config/calendar.php');

            foreach ((array)$data as $key => $value) {
                $config[ $key ] = $value;
            }

            file_put_contents(base_path().'/config/calendar.php', '<?php return '.var_export($config, true).';');

            return true;
        } else {
            return false;
        }
    }
}
