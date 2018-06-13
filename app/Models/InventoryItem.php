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
 * @property int $inventory_category_id
 * @property bool $console
 * @property bool $vr
 * @property bool $game_pad
 * @property bool $move
 * @property int|null $players
 * @property-read \App\Models\InventoryCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventoryItem whereConsole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventoryItem whereGamePad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventoryItem whereInventoryCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventoryItem whereMove($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventoryItem wherePlayers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventoryItem whereVr($value)
 */
class InventoryItem extends Model
{
	use SoftDeletes;
	
	protected $table = "sherna_inventory_items";
	protected $dates = ['deleted_at'];
	protected $fillable = [
		'inventory_category_id',
		'location_id',
		'console_id',
		'name',
		'serial_id',
		'inventory_id',
		'note',
		'console',
		'vr',
		'game_pad',
		'kinect',
		'move',
		'players',
		'guitar'
	];
	
	public function category()
	{
		return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
	}
	
	public function consoleObj()
	{
		return $this->belongsTo(Console::class, 'console_id');
	}
	
	public function location()
	{
		return $this->belongsTo(Location::class, 'location_id');
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
