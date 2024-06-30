<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Blog\Http\Controllers\Controller;
use Modules\Blog\Http\Requests\Testimony\StoreRequest;
use Modules\Blog\Http\Requests\Testimony\UpdateRequest;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Testimony;

class TestimonyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('access', Testimony::class);

        $testimonies = Testimony::search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->latest()
            ->paginate($request->get('limit', 10));

        $testimony_count = Testimony::count();

        return view('blog::testimony.index', compact('testimonies', 'testimony_count'));
    }

    /**
     * Display create resource page.
     */
    public function create()
    {
        $this->authorize('store', Testimony::class);

        return view('blog::testimony.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $testimony = new Testimony($request->transformed()->toArray());
        if ($testimony->save()) {
            return redirect()->next()->with('success', 'Testimoni <strong>' . $testimony->name . '</strong> berhasil dibuat');
        }
        return redirect()->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Testimony $testimony)
    {
        $this->authorize('update', $testimony);

        return view('blog::testimony.show', compact('testimony'));
    }

    /**
     * Display the specified resource.
     */
    public function update(UpdateRequest $request, Testimony $testimony)
    {
        $this->authorize('update', $testimony);

        $testimony->fill($request->transformed()->toArray());

        if ($testimony->save()) {
            return redirect()->next()->with('success', 'Testimoni <strong>' . $testimony->name . '</strong> berhasil diperbarui');
        }
        return redirect()->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimony $testimony)
    {
        $this->authorize('destroy', $testimony);
        $tmp = $testimony;
        if ($testimony->delete()) {
            return redirect()->next()->with('success', 'Testimoni <strong>' . $tmp->name . '</strong> berhasil dihapus');
        }
        return redirect()->fail();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Testimony $testimony)
    {
        $this->authorize('restore', $testimony);
        if ($testimony->restore()) {
            return redirect()->next()->with('success', 'kategori <strong>' . $testimony->title . '</strong> berhasil dipulihkan');
        }
        return redirect()->fail();
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(Testimony $testimony)
    {
        $this->authorize('restore', $testimony);
        $tmp = $testimony;
        if ($testimony->forceDelete()) {
            return redirect()->next()->with('success', 'Testimoni <strong>' . $tmp->name . '</strong> berhasil dihapus permanen dari sistem');
        }
        return redirect()->fail();
    }
}
