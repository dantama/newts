<?php

namespace Modules\Blog\Models\Observers;

use Illuminate\Support\Str;
use Auth;
use Modules\Blog\Models\BlogPost;
use Modules\Blog\Models\BlogPostMeta;

class BlogPostObserver
{
    /**
     * Handle the BlogPost "saving" event.
     */
    public function saving(BlogPost $post)
    {
        $post->slug = Str::slug($post->title);
    }

    /**
     * Handle the BlogPost "saved" event.
     */
    public function saved(BlogPost $post)
    {
        if ($post->metas()->doesntExist())
            $post->insertDefaultMetas($post);
    }
}
