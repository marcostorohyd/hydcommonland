<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoryChangeSectorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory_change_sector', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('directory_change_id');
            $table->unsignedInteger('sector_id');

            $table->foreign('directory_change_id')->references('id')->on('directory_changes')->onDelete('cascade');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->unique(['directory_change_id', 'sector_id']);
            $table->index(['directory_change_id', 'sector_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directory_change_sector');
    }
}
