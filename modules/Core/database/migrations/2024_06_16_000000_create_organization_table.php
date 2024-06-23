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
        Schema::create('departements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd');
            $table->foreign('parent_id')->references('id')->on('departements')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('kd');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('level')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd');
        });

        Schema::create('position_trees', function (Blueprint $table) {
            $table->unsignedSmallInteger('position_id');
            $table->unsignedSmallInteger('parent_id');

            $table->primary(['position_id', 'parent_id']);
            $table->foreign('position_id')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('position_meta', 'position_id', 'positions', 'unsignedSmallInteger');

        Schema::create('levels', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedSmallInteger('type');
            $table->string('kd')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('code')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('kd')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        MetableSchema::create('contract_meta', 'contract_id', 'contracts', 'unsignedTinyInteger');

        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('type')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('unit_trees', function (Blueprint $table) {
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('parent_id');

            $table->primary(['unit_id', 'parent_id']);
            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('units')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('units_meta', 'unit_id', 'units', 'unsignedInteger');

        Schema::create('unit_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unit_id');
            $table->unsignedInteger('dept_id');
            $table->string('description')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dept_id')->references('id')->on('departements')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('unit_departments')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('unit_positions', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('unit_id');
            $table->unsignedSmallInteger('position_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unit_id')->nullable();
            $table->unsignedSmallInteger('type');
            $table->unsignedInteger('user_id');
            $table->string('nbts')->nullable();
            $table->string('nbm')->nullable();
            $table->text('qr')->nullable();
            $table->timestamp('joined_at');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('members_meta', 'member_id', 'members', 'unsignedInteger');

        Schema::create('member_levels', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('member_id');
            $table->unsignedTinyInteger('level_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('member_achievements', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedInteger('member_id');
            $table->nullableMorphs('modelable_id');
            $table->string('label');
            $table->unsignedTinyInteger('achievement_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('managers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('unit_dept_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('unit_dept_id')->references('id')->on('unit_departments')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('managers_meta', 'manager_id', 'managers', 'unsignedInteger');

        Schema::create('manager_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd');
            $table->unsignedInteger('manager_id');
            $table->unsignedTinyInteger('contract_id');
            $table->unsignedInteger('unit_position_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd');
            $table->foreign('manager_id')->references('id')->on('managers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('unit_position_id')->references('id')->on('unit_positions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_positions');
        Schema::dropIfExists('member_levels');
        Schema::dropIfExists('members');
        Schema::dropIfExists('unit_positions');
        Schema::dropIfExists('unit_departments');
        Schema::dropIfExists('org_trees');
        Schema::dropIfExists('units');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('position_trees');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('departements');
    }
};
