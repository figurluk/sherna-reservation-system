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
 * App\Models\Badge
 *
 * @property int            $id
 * @property int            $user_uid
 * @property string         $image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereCreatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereDeletedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereId( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereImage( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereUpdatedAt( $value )
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge whereUserUid( $value )
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Badge withoutTrashed()
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Badge whereName($value)
 */
class Badge extends Model
{
	use SoftDeletes;
	
	protected $table = "sherna_badges";
	protected $dates = ['deleted_at'];
	protected $fillable = [
		'name',
		'system'
	];
	
	public function users()
	{
		return $this->belongsToMany(User::class, 'sherna_badges_users');
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
