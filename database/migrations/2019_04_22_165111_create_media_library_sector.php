<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaLibrarySector extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_library_sector', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('media_library_id');
            $table->unsignedInteger('sector_id');

            $table->foreign('media_library_id')->references('id')->on('media_libraries');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->unique(['media_library_id', 'sector_id']);
            $table->index(['media_library_id', 'sector_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_library_sector');
    }
}
