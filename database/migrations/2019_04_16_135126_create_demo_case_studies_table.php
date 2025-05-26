<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemoCaseStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_case_studies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('date');
            $table->string('address')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('link')->nullable();
            $table->string('email')->nullable();
            $table->string('image');
            $table->unsignedInteger('condition_id');
            $table->unsignedInteger('status_id');

            $table->unsignedInteger('created_by_id')->nullable();
            $table->unsignedInteger('updated_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('condition_id')->references('id')->on('conditions');
            $table->foreign('status_id')->references('id')->on('statuses');
        });

        Schema::create('demo_case_study_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('demo_case_study_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('locale')->index();

            $table->unique(['demo_case_study_id', 'locale']);
            $table->foreign('demo_case_study_id')->references('id')->on('demo_case_studies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demo_case_study_translations');
        Schema::dropIfExists('demo_case_studies');
    }
}
