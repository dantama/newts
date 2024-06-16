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
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('level')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('org_trees', function (Blueprint $table) {
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('parent_id');

            $table->primary(['organization_id', 'parent_id']);
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('organizations_meta', 'organization_id', 'organizations', 'unsignedInteger');

        Schema::create('org_depts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('organization_id');
            $table->string('kd');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd');
            $table->foreign('parent_id')->references('id')->on('org_depts')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('org_positions', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('kd');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('level')->nullable();
            $table->string('ctg')->nullable();
            $table->unsignedInteger('dept_id')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd');
            $table->foreign('dept_id')->references('id')->on('org_depts')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('org_position_trees', function (Blueprint $table) {
            $table->unsignedSmallInteger('position_id');
            $table->unsignedSmallInteger('parent_id');

            $table->primary(['position_id', 'parent_id']);
            $table->foreign('position_id')->references('id')->on('org_positions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('org_positions')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('org_position_meta', 'position_id', 'org_positions', 'unsignedSmallInteger');

        Schema::create('org_contracts', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('kd')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd', 'org_kd_unique');
        });

        MetableSchema::create('org_contract_meta', 'contract_id', 'org_contracts', 'unsignedTinyInteger');

        Schema::create('org_levels', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedSmallInteger('type');
            $table->string('kd')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd', 'org_kd_unique');
        });

        Schema::create('org_members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('type');
            $table->unsignedInteger('user_id');
            $table->string('nbts')->nullable();
            $table->string('nbm')->nullable();
            $table->text('qr')->nullable();
            $table->timestamp('joined_at');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('org_member_levels', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedInteger('member_id');
            $table->unsignedTinyInteger('level_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('org_member_positions', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedInteger('member_id');
            $table->unsignedSmallInteger('position_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->text('meta')->nullable();
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
        Schema::dropIfExists('org_contracts');
        Schema::dropIfExists('position_trees');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('depts');
        Schema::dropIfExists('organizations');
    }
};
