<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Blog\Models\Template;
use Modules\Blog\Http\Controllers\Controller;
use Modules\Blog\Http\Requests\Pages\StoreRequest;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $pages = Template::paginate($request->get('limit', 10));
        $page_count = Template::count();

        return view('blog::page.index', compact('pages', 'page_count'));
    }

    public function create(Request $request)
    {
        return view('blog::page.create');
    }

    public function store(StoreRequest $request)
    {
        $page = new Template($request->transformed()->toArray());

        if ($page->save()) {
            return redirect()->next()->with('success', 'Berhasil disimpan');
        }
        return redirect()->fail();
    }

    public function show(Template $page)
    {
        $template = $page;

        return view('blog::page.builder.new', compact('template'));
    }

    public function update(Request $request)
    {
        $page = Template::updateOrCreate(
            ['id' => $request->id],
            ['content' => $request->content]
        );

        return response()->json(['success' => true, 'page_id' => $page->id]);
    }
}
