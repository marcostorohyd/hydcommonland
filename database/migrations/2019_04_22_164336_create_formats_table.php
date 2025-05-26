<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('color', 6);
            $table->string('media_collection');

            $table->unsignedInteger('created_by_id')->nullable();
            $table->unsignedInteger('updated_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('format_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('format_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('locale')->index();

            $table->unique(['format_id', 'locale']);
            $table->foreign('format_id')->references('id')->on('formats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('format_translations');
        Schema::dropIfExists('formats');
    }
}
