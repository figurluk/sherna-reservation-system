<?php
/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 15/02/2017
 * Time: 19:40
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Shop\Language
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Category[] $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Manufacturer[] $manufacturers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Subpage[] $subpages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Setting[] $settings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Payment[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Delivery[] $deliveries
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\StateName[] $statesNames
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop\Customer[] $customers
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop\Language whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop\Language whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop\Language whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Shop\Language whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    protected $table = "languages";

    protected $guarded = [
        //
    ];
}
