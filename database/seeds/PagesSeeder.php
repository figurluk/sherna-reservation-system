<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 06.03.17
 * Time: 22:08
 */
class PagesSeeder extends Seeder
{

    public function run()
    {
        \App\Models\Page::create([
            'name'    => 'Domů',
            'code'    => 'domu',
            'public'  => true,
        ]);
        \App\Models\Page::create([
            'name'    => 'O SHerne',
            'code'    => 'o-sherne',
            'public'  => false,
        ]);
        \App\Models\Page::create([
            'name'    => 'Clenove',
            'code'    => 'clenove',
            'public'  => false,
        ]);
        \App\Models\Page::create([
            'name'    => 'Vyrocni spravy',
            'code'    => 'vyrocni-spravy',
            'public'  => false,
        ]);
        \App\Models\Page::create([
            'name'    => 'Rezervace',
            'code'    => 'rezervace',
            'public'  => false,
        ]);
        \App\Models\Page::create([
            'name'    => 'Turnaje',
            'code'    => 'turnaje',
            'public'  => false,
        ]);
        \App\Models\Page::create([
            'name'    => 'Vybaveni',
            'code'    => 'vybaveni',
            'public'  => false,
        ]);
    }

}