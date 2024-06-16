<?php

use App\Models\Traits\Metable\MetableSchema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->timestamps();
        });

        Schema::create('app_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('app_failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('app_permissions', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('key')->unique();
            $table->string('name')->nullable();
            $table->string('module')->nullable();
            $table->string('model')->nullable();
            $table->text('description')->nullable();
            $table->string('guard_name')->default('web');
        });

        Schema::create('app_roles', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('kd')->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('guard_name')->default('web');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('app_role_permissions', function (Blueprint $table) {
            $table->unsignedSmallInteger('role_id');
            $table->unsignedSmallInteger('permission_id');

            $table->foreign('role_id')->references('id')->on('app_roles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('app_permissions')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['role_id', 'permission_id']);
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('approvables', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('modelable');
            $table->morphs('userable');
            $table->unsignedTinyInteger('level')->default(1);
            $table->unsignedTinyInteger('cancelable')->default(0);
            $table->unsignedTinyInteger('result')->default(0);
            $table->text('reason')->nullable();
            $table->text('history')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approvables');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('app_permissions');
        Schema::dropIfExists('app_failed_jobs');
        Schema::dropIfExists('app_jobs');
        Schema::dropIfExists('app_settings');
    }
};
