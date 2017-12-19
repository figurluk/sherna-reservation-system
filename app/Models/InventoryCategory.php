<?php

/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 21/02/2017
 */


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\InventoryItem
 *
 * @property int                       $id
 * @property int                       $location_id
 * @property string                    $name
 * @property string                    $serial_id
 * @property string                    $inventory_id
 * @property string                    $note
 * @property \Carbon\Carbon            $created_at
 * @property \Carbon\Carbon            $updated_at
 * @property \Carbon\Carbon            $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem whereDeletedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem whereInventoryId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem whereLocationId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem whereName( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem whereNote( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem whereSerialId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem whereUpdatedAt( $value )
 * @mixin \Eloquent
 * @property-read \App\Models\Location $location
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\InventoryItem withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InventoryItem[] $items
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InventoryCategoryText[] $texts
 */
class InventoryCategory extends Model
{
	use SoftDeletes;
	
	protected $table = "inventory_categories";
	protected $dates = ['deleted_at'];
	protected $fillable = [
	];
	
	public function items()
	{
		return $this->hasMany(InventoryItem::class, 'inventory_category_id');
	}
	
	public function texts()
	{
		return $this->hasMany(InventoryCategoryText::class, 'inventory_category_id');
	}
	
	
	protected static function boot()
	{
		parent::boot();
		
		static::saving(function ( $item ) {
		});
		static::deleting(function ( $item ) {
		});
	}
}
