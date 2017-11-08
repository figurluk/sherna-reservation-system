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
 * App\Models\Location
 *
 * @property int                                                                 $id
 * @property int                                                                 $location_status_id
 * @property string                                                              $name
 * @property \Carbon\Carbon                                                      $created_at
 * @property \Carbon\Carbon                                                      $updated_at
 * @property \Carbon\Carbon                                                      $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereDeletedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereLocationStatusId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereName( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereUpdatedAt( $value )
 * @mixin \Eloquent
 * @property-read \App\Models\LocationStatus                                     $status
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location withoutTrashed()
 * @property string|null                                                         $reader_uid
 * @property string|null                                                         $location_uid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereLocationUid( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereReaderUid( $value )
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Console[] $consoles
 */
class Location extends Model
{
	use SoftDeletes;
	
	protected $table = "sherna_locations";
	protected $dates = ['deleted_at'];
	protected $fillable = [
		'location_status_id',
		'reader_uid',
		'location_uid',
		'name',
	];
	
	public function status()
	{
		return $this->belongsTo(LocationStatus::class, 'location_status_id');
	}
	
	public function isOpened()
	{
		return $this->status->opened;
	}
	
	public function consoles()
	{
		return $this->hasMany(Console::class);
	}
	
	public function scopeOpened( $query )
	{
		return $query->whereHas('status', function ( $q ) {
			$q->where('opened', true);
		});
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
