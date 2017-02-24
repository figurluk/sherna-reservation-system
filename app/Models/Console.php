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
 * App\Models\Console
 *
 * @property int            $id
 * @property string         $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int            $location_id
 * @property int            $console_type_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereConsoleTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Console whereLocationId($value)
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\ConsoleType $type
 */
class Console extends Model
{
    use SoftDeletes;

    protected $table = "sherna_consoles";
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'console_type_id',
        'location_id'
    ];

    public function type()
    {
        return $this->belongsTo(ConsoleType::class, 'console_type_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
        });
        static::deleting(function ($item) {
        });
    }
}
