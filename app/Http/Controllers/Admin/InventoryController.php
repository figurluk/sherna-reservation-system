<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventoryItems = InventoryItem::paginate(20);

        return view('admin.inventory.index', compact(['inventoryItems']));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function edit($id)
    {
        $inventoryItem = InventoryItem::find($id);

        return view('admin.inventory.edit', compact(['inventoryItem']));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|string|max:255',
            'serial_id'    => '',
            'inventory_id' => '',
            'location_id'  => 'required'
        ]);

        InventoryItem::create($request->all());
        flash()->success('Inventory item successfully created');

        return redirect()->action('Admin\InventoryController@index');
    }

    public function delete($id, Request $request)
    {
        $inventoryItem = InventoryItem::find($id);
        $inventoryItem->delete();
        flash()->success('Inventory item successfully deleted');

        return redirect()->action('Admin\InventoryController@index');
    }
}
