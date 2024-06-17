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
        Schema::create('depts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd');
            $table->foreign('parent_id')->references('id')->on('depts')->onUpdate('cascade')->onDelete('set null');
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

        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('type')->nullable();
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
            $table->unsignedInteger('dept_id');
            $table->string('description')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dept_id')->references('id')->on('depts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('org_depts')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('org_positions', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('org_dept_id');
            $table->unsignedSmallInteger('position_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('org_dept_id')->references('id')->on('org_depts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('organization_id');
            $table->unsignedSmallInteger('type');
            $table->unsignedInteger('user_id');
            $table->string('nbts')->nullable();
            $table->string('nbm')->nullable();
            $table->text('qr')->nullable();
            $table->timestamp('joined_at');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('members_meta', 'member_id', 'members', 'unsignedInteger');

        Schema::create('member_levels', function (Blueprint $table) {
            $table->tinyIncrements('id');
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

        Schema::create('member_contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd');
            $table->unsignedInteger('member_id');
            $table->unsignedTinyInteger('contract_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd');
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('member_contract_meta', 'member_contract_id', 'member_contracts', 'unsignedInteger');

        Schema::create('member_positions', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('org_position_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('org_position_id')->references('id')->on('org_positions')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('org_contracts');
        Schema::dropIfExists('org_positions');
        Schema::dropIfExists('org_depts');
        Schema::dropIfExists('org_trees');
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('position_trees');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('depts');
    }
};
