<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->string('register_url')->nullable();
            $table->unsignedInteger('assistance_id')->nullable();
            $table->unsignedInteger('type_id');
            $table->string('language', 20)->nullable();
            $table->string('venue_name')->nullable();
            $table->string('venue_address')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('image');
            $table->unsignedInteger('status_id');

            $table->unsignedInteger('created_by_id')->nullable();
            $table->unsignedInteger('updated_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assistance_id')->references('id')->on('event_assistances');
            $table->foreign('type_id')->references('id')->on('event_types');
            $table->foreign('status_id')->references('id')->on('statuses');
        });

        Schema::create('event_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('locale')->index();

            $table->unique(['event_id', 'locale']);
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_translations');
        Schema::dropIfExists('events');
    }
}
