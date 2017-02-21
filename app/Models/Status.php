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
 * App\Models\Status
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Status whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Status whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Status whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Status whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Status extends Model
{
    use SoftDeletes;
   
    protected $table = "sherna_statuses";
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
