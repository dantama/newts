<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BlogPostTag extends Model
{
    /**
     * The database table used by the model.
     */
    protected $table = 'blog_post_tags';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'post_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'post_id', 'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'post_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * This belongsTo post.
     */
    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'post_id');
    }

    /**
     * Scope where name like.
     */
    public function scopeWhereNameLike($query, $tag)
    {
        return $query->where('name', 'like', '%' . $tag . '%');
    }

    /**
     * Scope search.
     */
    public function scopeSearch($query, $tag)
    {
        return $query->whereNameLike($tag)->get('name')->pluck('name')->unique();
    }

    /**
     * Scope get and count.
     */
    public function scopeGetAndCount($query)
    {
        return $query->groupBy('name')->get(DB::raw('name, COUNT(name) AS posts_count'));
    }
}
