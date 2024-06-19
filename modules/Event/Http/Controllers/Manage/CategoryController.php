<?php

namespace Modules\Event\Http\Controllers\Manage;

use Illuminate\Http\Request;
use Modules\Event\Http\Controllers\Controller;

use Modules\Event\Models\Event;
use Modules\Event\Models\EventCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events = EventCategory::all();

        return view('event::manage.category.index', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newCategory = new EventCategory([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        $newCategory->save();

        return redirect()->back()->with('success', 'Kategori event <strong>' . $newCategory->name . '</strong> berhasil dibuat');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $category)
    {
        $newCategory = EventCategory::updateorcreate(['id' => $request->input('updateid')], [
            'name' => $request->input('updatename'),
            'description' => $request->input('updatedesc')
        ]);

        return redirect()->back()->with('success', 'Kategori event <strong>' . $newCategory->name . '</strong> berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $user = auth()->user();
        $managerial = $user->flattenManagerials()->first();

        if (Event::whereManagementIn($managerial->pivot)->find($event->id)) {
            $tmp = $event;
            $event->delete();

            return redirect()->back()->with('success', 'Event <strong>' . $tmp->name . ' (ID: ' . $tmp->id . ')</strong> berhasil dihapus');
        }

        return redirect()->back()->with('danger', 'Terjadi kegagalan!');
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Event $event)
    {
        $user = auth()->user();
        $managerial = $user->flattenManagerials()->first();

        if (Event::onlyTrashed()->whereManagementIn($managerial->pivot)->find($event->id)) {
            $tmp = $event;
            $event->forceDelete();

            return redirect()->back()->with('success', 'Event <strong>' . $tmp->name . ' (ID: ' . $tmp->id . ')</strong> berhasil dihapus secara permanen');
        }

        return redirect()->back()->with('danger', 'Terjadi kegagalan!');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Event $event)
    {
        $user = auth()->user();
        $managerial = $user->flattenManagerials()->first();

        if (Event::onlyTrashed()->whereManagementIn($managerial->pivot)->find($event->id)) {
            $tmp = $event;
            $event->restore();

            return redirect()->back()->with('success', 'Event <strong>' . $tmp->name . ' (ID: ' . $tmp->id . ')</strong> berhasil dipulihkan');
        }

        return redirect()->back()->with('danger', 'Terjadi kegagalan!');
    }
}
