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
 * App\Models\Game
 *
 * @property int            $id
 * @property string         $name
 * @property int            $possible_players
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Game whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Game whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Game whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Game wherePossiblePlayers($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Game whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int            $console_type_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Game whereConsoleTypeId($value)
 * @property-read \App\Models\ConsoleType $consoleType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 */
class Game extends Model
{
    use SoftDeletes;

    protected $table = "sherna_games";
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'possible_players',
        'console_type_id'
    ];

    public function consoleType()
    {
        return $this->belongsTo(ConsoleType::class, 'console_type_id');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'sherna_games_locations');
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
