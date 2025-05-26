<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaLibraryTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_library_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('media_library_id');
            $table->unsignedInteger('tag_id');

            $table->foreign('media_library_id')->references('id')->on('media_libraries');
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->unique(['media_library_id', 'tag_id']);
            $table->index(['media_library_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_library_tag');
    }
}
