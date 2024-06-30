<?php

namespace Modules\Blog\Http\Controllers\Article;

use Illuminate\Http\Request;
use Modules\Blog\Http\Controllers\Controller;
use Modules\Blog\Http\Requests\Article\Post\StoreRequest;
use Modules\Blog\Http\Requests\Article\Post\UpdateRequest;
use Modules\Blog\Models\BlogCategory;
use Modules\Blog\Models\BlogPost;
use Modules\Blog\Models\BlogPostTag;
use Modules\Blog\Models\PostTag;
use Modules\Blog\Repositories\PostRepository;

class PostController extends Controller
{
    use PostRepository;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('access', BlogPost::class);

        $posts = BlogPost::search($request->get('search'))
            ->whenTrashed($request->get('trash'))
            ->latest()
            ->paginate($request->get('limit', 10));

        $post_count = BlogPost::count();

        return view('blog::article.post.index', compact('posts', 'post_count'));
    }

    /**
     * Display create resource page.
     */
    public function create()
    {
        $this->authorize('store', BlogPost::class);

        return view('blog::article.post.create', [
            'categories' => BlogCategory::all(),
            'tags' => BlogPostTag::get()->pluck('name')->unique()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if ($post = $this->storePost($request->transformed()->toArray(), $request->user())) {
            return redirect()->next()->with('success', 'Artikel <strong>' . $post->title . '</strong> berhasil dibuat');
        }
        return redirect()->fail();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, BlogPost $post)
    {
        $this->authorize('update', $post);

        return view('blog::article.post.show', compact('post'));
    }

    /**
     * Display the specified resource.
     */
    public function edit(Request $request, BlogPost $post)
    {
        $this->authorize('update', $post);
        $categories = BlogCategory::all();
        $tags = BlogPostTag::get()->pluck('name')->unique();

        return view('blog::article.post.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * update the specified resource to storage.
     */
    public function update(BlogPost $post, UpdateRequest $request)
    {
        return $request->transformed()->toArray();
        $this->authorize('destroy', $post);
        if ($post = $this->updatePost($post, $request->transformed()->toArray(), $request->user())) {
            return redirect()->next()->with('success', 'Artikel <strong>' . $post->name . '</strong> berhasil diperbarui');
        }
        return redirect()->fail();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $post, Request $request)
    {
        $this->authorize('destroy', $post);
        if ($post = $this->removePost($post, $request->user())) {
            return redirect()->next()->with('success', 'Artikel <strong>' . $post->name . '</strong> berhasil dihapus');
        }
        return redirect()->fail();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(BlogPost $post, Request $request)
    {
        $this->authorize('restore', $post);
        if ($post = $this->restorePost($post, $request->user())) {
            return redirect()->next()->with('success', 'Artikel <strong>' . $post->title . '</strong> berhasil dipulihkan');
        }
        return redirect()->fail();
    }

    /**
     * Kill the specified resource from storage.
     */
    public function kill(BlogPost $post, Request $request)
    {
        $this->authorize('restore', $post);
        if ($post = $this->killPost($post, $request->user())) {
            return redirect()->next()->with('success', 'Artikel <strong>' . $post->title . ' </strong> berhasil dihapus permanen dari sistem');
        }
        return redirect()->fail();
    }
}
