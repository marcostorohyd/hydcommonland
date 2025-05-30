<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_libraries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('date');
            $table->unsignedInteger('country_id')->nullable();
            $table->string('author')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('format_id');
            $table->unsignedTinyInteger('external')->default(1);
            $table->string('link', 255)->nullable();
            $table->string('length', 5)->nullable();
            $table->unsignedInteger('status_id');

            $table->unsignedInteger('created_by_id')->nullable();
            $table->unsignedInteger('updated_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('format_id')->references('id')->on('formats');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_libraries');
    }
}
