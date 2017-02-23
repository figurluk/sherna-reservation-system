<?php

/**
 * Created by PhpStorm.
 * User: Lukas Figura
 * Date: 23/02/2017
 * Time: 22:34
 */

use Illuminate\Database\Seeder;

class LocationStatusSeeder extends Seeder
{

    public function run()
    {
        \App\Models\LocationStatus::create([
            'opened' => false,
            'name'   => 'Closed'
        ]);

        \App\Models\LocationStatus::create([
            'opened' => true,
            'name'   => 'Opened'
        ]);
    }

}