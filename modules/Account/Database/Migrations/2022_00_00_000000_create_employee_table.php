<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Traits\Metable\MetableSchema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('permanent_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        MetableSchema::create('employee_meta', 'empl_id', 'employees');

        Schema::create('employee_contracts', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedInteger('empl_id');
            $table->string('kd')->nullable();
            $table->unsignedTinyInteger('contract_id');
            $table->unsignedTinyInteger('work_location')->default(1);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique('kd');
            $table->foreign('empl_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('contract_id')->references('id')->on('cmp_contracts')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('employee_contract_meta', 'contract_id', 'employee_contracts', 'unsignedSmallInteger');

        Schema::create('employee_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('empl_id');
            $table->unsignedSmallInteger('position_id');
            $table->unsignedSmallInteger('contract_id')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('empl_id')->references('id')->on('employees')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('cmp_positions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('contract_id')->references('id')->on('employee_contracts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_positions');
        Schema::dropIfExists('employee_contract_meta');
        Schema::dropIfExists('employee_contracts');
        Schema::dropIfExists('employees');
    }
};
