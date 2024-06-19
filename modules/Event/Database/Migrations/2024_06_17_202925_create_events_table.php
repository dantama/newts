<?php

use App\Models\Traits\Metable\MetableSchema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('event_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kd');
            $table->string('title');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id')->nullable();
            $table->unsignedInteger('event_ctg_id')->nullable();
            $table->string('slug')->unique();
            $table->string('title');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->text('content')->nullable();
            $table->text('attachment')->nullable();
            $table->boolean('visibled')->default(1);
            $table->boolean('registerable')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('event_ctg_id')->references('id')->on('event_categories')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('events_meta', 'event_id', 'events', 'unsignedInteger');

        Schema::create('event_registrants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('register_id');
            $table->timestamp('register_at')->nullable();
            $table->timestamp('bill_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('register_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
        });

        MetableSchema::create('event_registrants_meta', 'registrant_id', 'event_registrants', 'unsignedInteger');

        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->nullableMorphs('modelable');
            $table->nullableMorphs('itemable');
            $table->text('meta');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->string('code')->unique();
            $table->double('final_price')->default(0);
            $table->timestamp('due_at')->nullable();
            $table->timestamp('paid_off_at')->nullable();
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->morphs('itemable');
            $table->double('price')->default(0);
            $table->text('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('invoice_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->string('code')->nullable();
            $table->string('payer')->nullable();
            $table->string('receipt')->nullable();
            $table->unsignedTinyInteger('method')->nullable();
            $table->double('paid_amount')->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //    
    }
};
