<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Language;
use App\Models\PageText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('code')->paginate(20);

        return view('admin.pages.index', compact(['pages']));
    }

    public function edit($id)
    {
        $page = Page::find($id);
        $lang = Language::pluck('name', 'id')->all();

        return view('admin.pages.edit', compact(['page', 'lang']));
    }


    public function update($id, Request $request)
    {
        $subpage = Page::findOrFail($id);

        foreach (Language::all() as $language) {
            $subpageText = $subpage->pageText()->ofLang($language->code)->first();
            if ($subpageText == null) {
                $subpageText = PageText::create([
                    'content' => Input::get('content-'.$language->id),
                ]);

                $subpageText->page()->associate($subpage);
                $subpageText->languages()->associate($language);
                $subpageText->save();
            } else {
                $subpageText->update([
                    'content' => Input::get('content-'.$language->id),
                ]);
            }
        }
        $subpage->save();

        flash()->success('Page successfully updated');

        return redirect()->action('Admin\PagesController@index');
    }

    public function unvisible($id)
    {
        $page = Page::find($id);
        $page->public = false;
        $page->save();
        flash()->success('Page is not public');

        return redirect()->action('Admin\PagesController@index');
    }

    public function visible($id)
    {
        $page = Page::find($id);
        $page->public = true;
        $page->save();
        flash()->success('Page is public');

        return redirect()->action('Admin\PagesController@index');
    }
}
