<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Console;
use App\Models\ConsoleType;
use Illuminate\Http\Request;

class ConsolesController extends Controller
{
    public function index()
    {
        $consoles = Console::paginate(15);
        $consolesTypes = ConsoleType::get();

        return view('admin.consoles.index', compact(['consoles', 'consolesTypes']));
    }

    public function create()
    {
        return view('admin.consoles.create');
    }

    public function edit($id)
    {
        $console = Console::find($id);

        return view('admin.consoles.edit',compact(['console']));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'            => 'required|string|max:255',
            'console_type_id' => 'required',
            'location_id'     => 'required',
        ]);

        Console::create($request->all());
        flash()->success('Console successfully created');

        return redirect()->action('Admin\ConsolesController@index');
    }


    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name'            => 'required|string|max:255',
            'console_type_id' => 'required',
            'location_id'     => 'required',
        ]);

        $console = Console::find($id);
        $console->update($request->all());
        flash()->success('Console successfully updated');

        return redirect()->action('Admin\ConsolesController@index');
    }

    public function delete($id, Request $request)
    {
        $console = Console::find($id);
        $console->delete();
        flash()->success('Console successfully deleted');

        return redirect()->action('Admin\ConsolesController@index');
    }

    public function createConsoleType()
    {
        return view('admin.consoles.types.create');
    }

    public function editConsoleType($id)
    {
        $consoleType = ConsoleType::find($id);

        return view('admin.consoles.types.edit', compact(['consoleType']));
    }

    public function storeConsoleType(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        ConsoleType::create($request->all());
        flash()->success('Console type successfully created');

        return redirect()->action('Admin\ConsolesController@index');
    }


    public function updateConsoleType($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $consoleType = ConsoleType::find($id);
        $consoleType->update($request->all());
        flash()->success('Console type successfully updated');

        return redirect()->action('Admin\ConsolesController@index');
    }
}
