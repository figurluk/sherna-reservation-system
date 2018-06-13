<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryCategory;
use App\Models\InventoryCategoryText;
use App\Models\InventoryItem;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class InventoryController extends Controller
{
	public function index()
	{
		$inventoryItems = InventoryItem::orderBy('name','asc')->paginate(20);
		
		return view('admin.inventory.index', compact(['inventoryItems']));
	}
	
	public function create()
	{
		return view('admin.inventory.create');
	}
	
	public function edit( $id )
	{
		$inventoryItem = InventoryItem::find($id);
		
		return view('admin.inventory.edit', compact(['inventoryItem']));
	}
	
	public function store( Request $request )
	{
		$this->validate($request, [
			'name'                  => 'required|string|max:255',
			'inventory_category_id' => 'required',
			'serial_id'             => '',
			'inventory_id'          => '',
			'location_id'           => 'required',
		]);
		
		InventoryItem::create($request->all());
		flash()->success('Inventory item successfully created');
		
		return redirect()->action('Admin\InventoryController@index');
	}
	
	public function update( $id, Request $request )
	{
		$inventoryItem = InventoryItem::findOrFail($id);
		
		$this->validate($request, [
			'name'                  => 'required|string|max:255',
			'inventory_category_id' => 'required',
			'serial_id'             => '',
			'inventory_id'          => '',
			'location_id'           => 'required',
		]);
		
		$inventoryItem->update($request->all());
		flash()->success('Inventory item successfully updated');
		
		return redirect()->action('Admin\InventoryController@index');
	}
	
	public function delete( $id, Request $request )
	{
		$inventoryItem = InventoryItem::find($id);
		$inventoryItem->delete();
		flash()->success('Inventory item successfully deleted');
		
		return redirect()->action('Admin\InventoryController@index');
	}
	
	
	public function indexCategories()
	{
		$inventoryCategories = InventoryCategory::paginate(20);
		
		return view('admin.inventory.indexCategories', compact(['inventoryCategories']));
	}
	
	public function createCategories()
	{
		$lang = Language::pluck('name', 'id')->all();
		
		return view('admin.inventory.createCategories', compact('lang'));
	}
	
	public function editCategories( $id )
	{
		$inventoryCategory = InventoryCategory::find($id);
		
		$lang = Language::pluck('name', 'id')->all();
		
		return view('admin.inventory.editCategories', compact(['inventoryCategory', 'lang']));
	}
	
	public function storeCategories( Request $request )
	{
		$rules = [];
		foreach (Language::all() as $language) {
			$rules['name-' . $language->id] = 'required|string|max:255';
		}
		$this->validate($request, $rules);
		
		$category = InventoryCategory::create([]);
		
		foreach (Language::all() as $language) {
			$categoryText = InventoryCategoryText::create([
				'name'                  => Input::get('name-' . $language->id),
				'language_id'           => $language->id,
				'inventory_category_id' => $category->id,
			]);
		}
		
		flash()->success('Inventory category successfully created');
		
		return redirect()->action('Admin\InventoryController@indexCategories');
	}
	
	public function updateCategories( $id, Request $request )
	{
		$rules = [];
		foreach (Language::all() as $language) {
			$rules['name-' . $language->id] = 'required|string|max:255';
		}
		$this->validate($request, $rules);
		
		$category = InventoryCategory::findOrFail($id);
		
		foreach (Language::all() as $language) {
			$categoryText = $category->texts()->ofLang($language->code)->first();
			if ($categoryText == null) {
				$categoryText = InventoryCategoryText::create([
					'name'                  => Input::get('name-' . $language->id),
					'language_id'           => $language->id,
					'inventory_category_id' => $category->id,
				]);
			} else {
				$categoryText->update([
					'name' => Input::get('name-' . $language->id),
				]);
			}
		}
		
		flash()->success('Inventory category successfully updated');
		
		return redirect()->action('Admin\InventoryController@indexCategories');
	}
	
	public function deleteCategories( $id, Request $request )
	{
		$inventoryCategory = InventoryCategory::find($id);
		$inventoryCategory->delete();
		flash()->success('Inventory category successfully deleted');
		
		return redirect()->action('Admin\InventoryController@indexCategories');
	}
}
