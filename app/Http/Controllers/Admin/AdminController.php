<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

}