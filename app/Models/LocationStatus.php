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
 * App\Models\LocationStatus
 *
 * @property int $id
 * @property bool $opened
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LocationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LocationStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LocationStatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LocationStatus whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LocationStatus whereOpened($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LocationStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LocationStatus extends Model
{
    use SoftDeletes;

    protected $table = "sherna_locations_statuses";
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'opened',
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
