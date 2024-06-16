<?php

namespace Modules\Administration\Http\Controllers\Blog;

use Str;
use Modules\Web\Models\BlogCategory;
use Modules\Administration\Http\Requests\Blog\Category\StoreRequest;
use Modules\Administration\Http\Requests\Blog\Category\UpdateRequest;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    	$categories = BlogCategory::withCount('posts')->when($request->get('search'), function ($query, $v) {
    		return $query->where('name', 'like', '%'.$v.'%');
    	})->orderByDesc('created_at')->paginate($request->get('limit', 10));

        return view('administration::blogs.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
    	$data = $request->validated();
    	$data['slug'] = Str::slug($data['name']);

        $category = new BlogCategory($data);
        $category->save();

        return redirect($request->get('next', route('administration::blog.categories.index')))
                    ->with('success', 'Kategori berhasil dibuat!');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $category)
    {
    	return view('administration::blogs.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, BlogCategory $category)
    {
        $data = $request->validated();
    	$data['slug'] = Str::slug($data['name']);

        $category = $category->fill($data);
        $category->save();

        return redirect($request->get('next', route('administration::blog.categories.index')))
                    ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $category)
    {
        $category->delete();

        return redirect(request('next', route('administration::blog.categories.index')))
                    ->with('success', 'Kategori berhasil dihapus!');
    }
}
