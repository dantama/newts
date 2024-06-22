<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Models\BlogCategory;
use Modules\Blog\Models\BlogPost;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blog_categories = array(
            array(
                "id" => 1,
                "slug" => "nasional",
                "name" => "Nasional",
                "metas" => NULL,
                "description" => NULL,
                "created_at" => "2020-06-24 12:45:23",
                "updated_at" => "2020-06-24 12:45:23",
            ),
            array(
                "id" => 2,
                "slug" => "wilayah",
                "name" => "Wilayah",
                "metas" => NULL,
                "description" => NULL,
                "created_at" => "2020-06-24 12:45:23",
                "updated_at" => "2020-07-05 16:54:18",
            ),
            array(
                "id" => 3,
                "slug" => "daerah",
                "name" => "Daerah",
                "metas" => NULL,
                "description" => NULL,
                "created_at" => "2020-06-24 12:45:23",
                "updated_at" => "2020-06-24 12:45:23",
            ),
            array(
                "id" => 4,
                "slug" => "cabang",
                "name" => "Cabang",
                "metas" => NULL,
                "description" => NULL,
                "created_at" => "2020-06-24 12:45:23",
                "updated_at" => "2020-06-24 12:45:23",
            ),
        );

        foreach ($blog_categories as $ctg) {
            BlogCategory::create($ctg);
        }

        DB::unprepared(file_get_contents(__DIR__ . '/post.sql'));

        $posts = BlogPost::all();
        foreach ($posts as $post) {
            $post->setMeta('title', $post->title);
            $post->setMeta('image', $post->img);
            $post->setMeta('description', $post->title);
        }
    }
}
