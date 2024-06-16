<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Traits\Metable\MetableSchema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email_address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->unsignedInteger('pemad_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE users AUTO_INCREMENT = 101001;');

        MetableSchema::create('user_metas', 'user_id', 'users');

        Schema::create('user_roles', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedSmallInteger('role_id');

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('app_roles')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['role_id', 'user_id']);
        });

        Schema::create('user_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('message');
            $table->nullableMorphs('modelable');
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('user_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('user_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->text('token');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_password_resets');
        Schema::dropIfExists('user_logs');
        Schema::dropIfExists('user_meta');
        Schema::dropIfExists('users');
    }
};
