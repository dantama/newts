<?php

namespace Modules\Event\Http\Controllers\Manage;

use Illuminate\Http\Request;
use Modules\Event\Http\Controllers\Controller;
use Modules\Event\Models\Event;
use Modules\Event\Http\Requests\Manage\Category\StoreRequest;
use Modules\Event\Http\Requests\Manage\Category\UpdateRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ctgs = Event::paginate($request->get('limit', 10));

        return view('event::manage.event.index', compact('ctgs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $category = new Event($request->transformed()->toArray());

        if ($category->save()) {
            return redirect()->back()->with('success', 'Kategori event <strong>' . $category->name . '</strong> berhasil dibuat');
        }
        return redirect()->fail();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Event $category)
    {
        return view('event::manage.event.show', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Event $category)
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
    public function destroy(Event $category)
    {
        $user = auth()->user();

        return redirect()->back()->with('danger', 'Terjadi kegagalan!');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Event $category)
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
