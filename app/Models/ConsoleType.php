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
 * @property int            $id
 * @property int            $location_status_id
 * @property string         $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereLocationStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Location whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConsoleType onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConsoleType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConsoleType withoutTrashed()
 */
class ConsoleType extends Model
{
    use SoftDeletes;

    protected $table = "sherna_consoles_types";
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
        });
        static::deleting(function ($item) {
        });
    }
}
