<?php

use App\Models\Language;
use App\Models\Page;
use App\Models\PageText;
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
			'code'   => 'domu',
			'public' => true,
		]);
		\App\Models\Page::create([
			'code'   => 'o-sherne',
			'public' => false,
		]);
		\App\Models\Page::create([
			'code'   => 'clenove',
			'public' => false,
		]);
		\App\Models\Page::create([
			'code'   => 'vyrocni-spravy',
			'public' => false,
		]);
		\App\Models\Page::create([
			'code'   => 'rezervace',
			'public' => false,
		]);
		\App\Models\Page::create([
			'code'   => 'turnaje',
			'public' => false,
		]);
		\App\Models\Page::create([
			'code'   => 'vybaveni',
			'public' => false,
		]);
		
		\App\Models\Page::create([
			'code'   => 'provozni-rad',
			'public' => false,
		]);
		
		\App\Models\Page::create([
			'code'   => 'navody',
			'public' => false,
		]);
		
		$arr = ['Domů', 'O SHerne', 'Členové', 'Výroční zprávy', 'Rezervace', 'Turnaje', 'Vybavení', 'Provozní řád', 'Navody'];
		
		foreach (Language::all() as $language) {
			$i = 0;
			foreach (Page::get() as $page) {
				if ($language->code == 'cz') {
					$subpageText = PageText::create([
						'name'    => $arr[$i],
						'content' => 'asdsad-' . $language->code,
					]);
				} else {
					$subpageText = PageText::create([
						'name'    => 'name-' . $language->code,
						'content' => 'content-' . $language->code,
					]);
				}
				
				$subpageText->page()->associate($page);
				$subpageText->languages()->associate($language);
				$subpageText->save();
				$i++;
			}
		}
		
	}
}