<?php

/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 24.02.17
 * Time: 18:32
 */
use Illuminate\Database\Seeder;


class ConsolesTypesSeeder extends Seeder
{

    public function run()
    {
        \App\Models\ConsoleType::create([
            'name' => 'XBox'
        ]);

        \App\Models\ConsoleType::create([
            'name' => 'PlayStation'
        ]);
    }

}