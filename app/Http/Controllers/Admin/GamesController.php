<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index()
    {
        $games = Game::paginate(15);

        return view('admin.games.index', compact(['games']));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function edit($id)
    {
        $game = Game::find($id);

        return view('admin.games.edit', compact(['game']));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'             => 'required|string|max:255',
            'possible_players' => 'required|numeric',
            'console_type_id'  => 'required',
            'location_id'      => 'required'
        ]);

        $game = Game::create($request->except('location_id'));
        $game->locations()->sync($request->location_id);
        flash()->success('Game successfully created');

        return redirect()->action('Admin\GamesController@index');
    }


    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name'             => 'required|string|max:255',
            'possible_players' => 'required|numeric',
            'console_type_id'  => 'required',
            'location_id'      => 'required'
        ]);

        $game = Game::find($id);
        $game->update($request->except('location_id'));
        $game->locations()->sync($request->location_id);
        flash()->success('Game successfully updated');

        return redirect()->action('Admin\GamesController@index');
    }

    public function delete($id, Request $request)
    {
        $game = Game::find($id);
        $game->delete();
        flash()->success('Game successfully deleted');

        return redirect()->action('Admin\GamesController@index');
    }
}
