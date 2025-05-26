<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemoCaseStudySector extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_case_study_sector', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('demo_case_study_id');
            $table->unsignedInteger('sector_id');

            $table->foreign('demo_case_study_id')->references('id')->on('demo_case_studies');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->unique(['demo_case_study_id', 'sector_id']);
            $table->index(['demo_case_study_id', 'sector_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demo_case_study_sector');
    }
}
