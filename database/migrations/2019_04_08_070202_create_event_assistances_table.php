<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAssistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_assistances', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('created_by_id')->nullable();
            $table->unsignedInteger('updated_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('event_assistance_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_assistance_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('locale')->index();

            $table->unique(['event_assistance_id', 'locale']);
            $table->foreign('event_assistance_id')->references('id')->on('event_assistances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_assistance_translations');
        Schema::dropIfExists('event_assistances');
    }
}
