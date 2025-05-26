<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoryChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directory_changes', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('web', 255)->nullable();
            $table->string('address')->nullable();
            $table->string('zipcode', 20);
            $table->string('city', 80);
            $table->unsignedInteger('country_id');
            $table->decimal('latitude', 12, 8)->nullable();
            $table->decimal('longitude', 12, 8)->nullable();
            $table->unsignedInteger('entity_id');
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->string('partners')->nullable();
            $table->string('members')->nullable();
            $table->string('represented')->nullable();
            $table->string('surface')->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->string('tiktok', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->string('vimeo', 255)->nullable();
            $table->string('whatsapp', 255)->nullable();
            $table->string('telegram', 255)->nullable();
            $table->string('research_gate', 255)->nullable();
            $table->string('orcid', 255)->nullable();
            $table->string('academia_edu', 255)->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id')->references('id')->on('directories');
        });


        Schema::create('directory_change_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('directory_change_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('locale')->index();

            $table->unique(['directory_change_id', 'locale']);
            $table->foreign('directory_change_id')->references('id')->on('directory_changes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directory_change_translations');
        Schema::dropIfExists('directory_changes');
    }
}
