<?php

use App\Models\Traits\Metable\MetableSchema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('img')->nullable();
            $table->string('title');
            $table->text('content')->nullable();
            $table->unsignedInteger('author_id')->nullable();
            $table->boolean('commentable')->default(1);
            $table->boolean('visibled')->default(1);
            $table->integer('views_count')->default(0);
            $table->unsignedTinyInteger('approved')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('blog_posts_meta', 'blog_post_id', 'blog_posts', 'unsignedInteger');

        Schema::create('blog_post_likes', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('liker_id');

            $table->primary(['post_id', 'liker_id']);
            $table->foreign('post_id')->references('id')->on('blog_posts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('blog_post_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('post_id');
            $table->text('content');
            $table->unsignedInteger('commentator_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('blog_posts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('blog_categories', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('metas')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('blog_post_categories', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->unsignedSmallInteger('category_id');

            $table->primary(['post_id', 'category_id']);

            $table->foreign('post_id')->references('id')->on('blog_posts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('blog_categories')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('blog_post_tags', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->string('name');

            $table->primary(['post_id', 'name']);

            $table->foreign('post_id')->references('id')->on('blog_posts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('blog_post_tags');
        Schema::dropIfExists('blog_post_categories');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('blog_post_comments');
        Schema::dropIfExists('blog_post_likes');
        Schema::dropIfExists('blog_post_metas');
        Schema::dropIfExists('blog_posts');
    }
}
