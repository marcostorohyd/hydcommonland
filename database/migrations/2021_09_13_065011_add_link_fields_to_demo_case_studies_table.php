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
        Schema::table('demo_case_studies', function (Blueprint $table) {
            $table->string('link2', 255)->nullable()->after('link');
            $table->string('link3', 255)->nullable()->after('link2');
            $table->string('link4', 255)->nullable()->after('link3');
            $table->string('link5', 255)->nullable()->after('link4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demo_case_studies', function (Blueprint $table) {
            $table->dropColumn('link2', 'link3', 'link4', 'link5');
        });
    }
};
