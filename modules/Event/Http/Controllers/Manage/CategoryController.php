<?php

namespace Modules\Event\Http\Controllers\Manage;

use Illuminate\Http\Request;
use Modules\Event\Http\Controllers\Controller;
use Modules\Event\Models\Event;
use Modules\Event\Models\EventType;
use Modules\Event\Http\Requests\Manage\Category\StoreRequest;
use Modules\Event\Http\Requests\Manage\Category\UpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ctgs = EventType::paginate($request->get('limit', 10));

        return view('event::manage.category.index', compact('ctgs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $category = new EventType($request->transformed()->toArray());

        if ($category->save()) {
            return redirect()->back()->with('success', 'Kategori event <strong>' . $category->name . '</strong> berhasil dibuat');
        }
        return redirect()->fail();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(EventType $category)
    {
        return view('event::manage.category.show', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, EventType $category)
    {
        $category->fill($request->transformed()->toArray());
        if ($category->save()) {
            return redirect()->back()->with('success', 'Kategori event <strong>' . $category->name . '</strong> berhasil diperbarui');
        }
        return redirect()->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventType $category)
    {
        $user = auth()->user();

        return redirect()->back()->with('danger', 'Terjadi kegagalan!');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(EventType $category)
    {
        $user = auth()->user();

        return redirect()->back()->with('danger', 'Terjadi kegagalan!');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Event $event)
    {
        $user = auth()->user();

        return redirect()->back()->with('danger', 'Terjadi kegagalan!');
    }
}
