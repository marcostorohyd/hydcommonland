<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
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
            $table->unsignedInteger('status_id');

            $table->unsignedInteger('created_by_id')->nullable();
            $table->unsignedInteger('updated_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('statuses');
        });

        Schema::create('directory_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('directory_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('locale')->index();

            $table->unique(['directory_id', 'locale']);
            $table->foreign('directory_id')->references('id')->on('directories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directory_translations');
        Schema::dropIfExists('directories');
    }
}
