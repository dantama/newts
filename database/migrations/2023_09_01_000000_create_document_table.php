<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd')->unique();
            $table->unsignedTinyInteger('type')->default(1);
            $table->string('qr')->nullable()->unique();
            $table->string('label')->nullable();
            $table->string('path')->nullable();
            $table->nullableMorphs('modelable');
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('doc_signatures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('qr')->nullable()->unique();
            $table->unsignedInteger('doc_id');
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('doc_id')->references('id')->on('docs')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('doc_signatures');
        Schema::dropIfExists('docs');
    }
}
