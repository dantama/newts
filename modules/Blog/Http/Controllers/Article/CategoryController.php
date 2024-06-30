<?php

namespace Modules\Blog\Http\Controllers\Article;

use Illuminate\Http\Request;
use Modules\Blog\Http\Controllers\Controller;
use Modules\Blog\Http\Requests\Article\Category\StoreRequest;
use Modules\Blog\Http\Requests\Article\Category\UpdateRequest;
use Modules\Blog\Models\BlogCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('access', BlogCategory::class);

        $categories = BlogCategory::withCount('posts')
            ->search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->latest()
            ->paginate($request->get('limit', 10));

        $category_count = BlogCategory::count();

        return view('blog::article.category.index', compact('categories', 'category_count'));
    }

    /**
     * Display create resource page.
     */
    public function create()
    {
        $this->authorize('store', BlogCategory::class);

        return view('blog::article.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $category = new BlogCategory($request->transformed()->toArray());
        if ($category->save()) {
            return redirect()->next()->with('success', 'kategori <strong>' . $category->title . '</strong> berhasil dibuat');
        }
        return redirect()->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, BlogCategory $category)
    {
        $this->authorize('update', $category);

        $category->loadCount('posts')->load(['posts' => fn ($p) => $p->latest()->limit(10)]);

        return view('blog::article.category.show', compact('category'));
    }

    /**
     * Display the specified resource.
     */
    public function update(UpdateRequest $request, BlogCategory $category)
    {
        $this->authorize('update', $category);

        $category->fill($request->transformed()->toArray());

        if ($category->save()) {
            return redirect()->next()->with('success', 'kategori <strong>' . $category->title . '</strong> berhasil diperbarui');
        }
        return redirect()->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $category)
    {
        $this->authorize('destroy', $category);
        $tmp = $category;
        if ($category->delete()) {
            return redirect()->next()->with('success', 'Kategori <strong>' . $tmp->title . '</strong> berhasil dihapus');
        }
        return redirect()->fail();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(BlogCategory $category)
    {
        $this->authorize('restore', $category);
        if ($category->restore()) {
            return redirect()->next()->with('success', 'kategori <strong>' . $category->title . '</strong> berhasil dipulihkan');
        }
        return redirect()->fail();
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(BlogCategory $category)
    {
        $this->authorize('restore', $category);
        $tmp = $category;
        if ($category->forceDelete()) {
            return redirect()->next()->with('success', 'Kategori <strong>' . $tmp->name . '</strong> berhasil dihapus permanen dari sistem');
        }
        return redirect()->fail();
    }
}
