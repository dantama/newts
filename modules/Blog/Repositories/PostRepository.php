<?php

namespace Modules\Blog\Repositories;

use Illuminate\Support\Arr;
use Modules\Account\Models\User;
use Modules\Blog\Models\BlogPost;

trait PostRepository
{
	private $metaKeys = [
		'poster_file', 'keyword', 'title', 'description'
	];
	/**
	 * Store newly created resource.
	 */
	public function storePost(array $data, User $user)
	{
		$post = new BlogPost(Arr::except($data, ['meta', 'category', 'tags']));
		if ($post->save()) {
			$post->setManyMeta(Arr::only($data['meta'], $this->metaKeys));
			$post->categories()->sync($data['category']);
			foreach (collect($data['tags']) ?? [] as $key => $value) {
				$post->tags()->create(['name' => $value]);
			}
			$user->log('membuat pengguna baru dengan nama ' . $post->title . ' <strong>[ID: ' . $post->id . ']</strong>', BlogPost::class, $post->id);
			return $post;
		}
		return false;
	}

	public function updatePost(BlogPost $post, array $data, User $user)
	{
		$post->fill(Arr::except($data, ['meta', 'category', 'tags']));
		if ($post->save()) {
			$post->setManyMeta(Arr::only($data['meta'], $this->metaKeys));
			$post->categories()->sync($data['category']);
			foreach (collect($data['tags']) ?? [] as $key => $value) {
				$post->tags()->create(['name' => $value]);
			}
			$user->log('membuat pengguna baru dengan nama ' . $post->title . ' <strong>[ID: ' . $post->id . ']</strong>', BlogPost::class, $post->id);
			return $post;
		}
		return false;
	}

	/**
	 * Remove the current resource.
	 */
	public function removePost(BlogPost $post, User $user)
	{
		$tmp = $post;
		if (!$post->trashed() && $post->delete()) {
			$user->log('menghapus artikel ' . $tmp->name . ' <strong>[ID: ' . $tmp->id . ']</strong>', BlogPost::class, $tmp->id);
			return $tmp;
		}
		return false;
	}

	/**
	 * Restore the current resource.
	 */
	public function restorePost(BlogPost $post, User $user)
	{
		if ($post->trashed() && $post->restore()) {
			$user->log('memulihkan artikel ' . $post->title . ' <strong>[ID: ' . $post->id . ']</strong>', BlogPost::class, $post->id);
			return $post;
		}
		return false;
	}

	/**
	 * Remove the current resource.
	 */
	public function killPost(BlogPost $post, User $user)
	{
		$tmp = $post;
		if (!$post->trashed() && $post->forceDelete()) {
			$user->log('menghapus artikel ' . $tmp->name . ' <strong>[ID: ' . $tmp->id . ']</strong>', BlogPost::class, $tmp->id);
			return $tmp;
		}
		return false;
	}
}
