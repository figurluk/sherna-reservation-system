<?php
use App\Models\Page;

/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 12/01/2017
 * Time: 15:41
 */

function getName($code)
{
    return Page::whereCode($code)->first()->pageText()->ofLang(App::getLocale())->first()->name;
}

function secure_action($name, $parameters = [], $absolute = true)
{
    return 'https://'.app('url')->action($name, $parameters, $absolute);
}
