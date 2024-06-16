<?php

namespace Modules\Administration\Http\Controllers\Blog;

use Modules\Web\Models\BlogPostComment;

use Illuminate\Http\Request;
use Modules\Administration\Http\Controllers\Controller;

class PostCommentController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function approve(Request $request, BlogPostComment $comment)
    {
        $comment->update([
            'published_at'  => isset($comment->published_at) ? null : now()
        ]);

        return redirect($request->get('next', route('administration::blog.posts.show', ['post' => $comment->post_id])))
                    ->with('success', 'Komentar berhasil di'.($comment->published_at ? 'approve' : 'reject').'!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BlogPostComment $comment)
    {
        $comment->delete();

        return redirect($request->get('next', route('administration::blog.posts.show', ['post' => $comment->post_id])))
                    ->with('success', 'Postingan berhasil dibuang!');
    }
}
