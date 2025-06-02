<?php

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
        Schema::create('directory_sector', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('directory_id');
            $table->unsignedInteger('sector_id');

            $table->foreign('directory_id')->references('id')->on('directories');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->unique(['directory_id', 'sector_id']);
            $table->index(['directory_id', 'sector_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directory_sector');
    }
};
