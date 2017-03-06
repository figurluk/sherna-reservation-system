<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Storage;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

    public function getImage($name)
    {
        $disk = Storage::disk('local');

        return $disk->get('/summer_images/' . $name);
    }

    public function saveImage(Request $request)
    {
        $disk = Storage::disk('local');
        if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(rand(100, 200));
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . $ext[1];

//                $destination = '/assets/images/' . $filename; //change this directory
                $destination = public_path();
                $destination .= "/summer_images/";


                $location = $_FILES["file"]["tmp_name"];

                if (!file_exists($destination)) {
                    File::makeDirectory($destination);
                }
                move_uploaded_file($location, $destination . $filename);
//                echo 'http://test.yourdomain.al/images/' . $filename;//change this URL
//                return action('Admin\AdminController@getImage', $filename);
                return asset(url('/summer_images/' . $filename));
            } else {
                echo $message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
            }
        }

        return "error";

    }

}