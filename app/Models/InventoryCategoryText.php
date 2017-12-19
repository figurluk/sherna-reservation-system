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
 * @property int $language_id
 * @property-read \App\Models\InventoryCategory $category
 * @property-read \App\Models\Language $languages
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventoryCategoryText ofLang($langCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventoryCategoryText whereInventoryCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InventoryCategoryText whereLanguageId($value)
 */
class InventoryCategoryText extends Model
{
	use SoftDeletes;
	
	protected $table = "inventory_categories_texts";
	protected $dates = ['deleted_at'];
	protected $fillable = [
		'language_id',
		'inventory_category_id',
		'name',
	];
	
	public function category()
	{
		return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
	}
	
	public function languages()
	{
		return $this->belongsTo(Language::class, 'language_id');
	}
	
	public function scopeOfLang($query, $langCode)
	{
		return $query->where('language_id', Language::where('code', $langCode)->first()->id);
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
