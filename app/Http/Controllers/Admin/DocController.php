<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocController extends Controller
{
    public function index()
    {
        $docs = \File::allFiles(public_path('docs'));

        return view('admin.doc.index', compact('docs'));
    }

    public function upload(Request $request)
    {
        $this->validate($request, ['file' => 'required']);

        if ($request->file('file')->isValid()) {
            $request->file->move(public_path('docs/'), $request->file->getClientOriginalName());
            flash()->success('Súbor úspešne nahraný.');
        } else {
            flash()->error('Súbor je poškodený.');
        }

        return redirect()->action('Admin\DocController@index');
    }

    public function delete($path)
    {
        \File::delete(public_path('docs/' . $path));

        flash()->success('Súbor úspešne zmazaný.');

        return redirect()->action('Admin\DocController@index');
    }
}
