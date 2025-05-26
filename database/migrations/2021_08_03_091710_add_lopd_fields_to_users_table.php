<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLopdFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('accept_lopd')->nullable()->after('approved_at');
            $table->boolean('accept_share')->nullable()->after('accept_lopd');
            $table->boolean('accept_advertising')->nullable()->after('accept_share');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['accept_lopd', 'accept_share', 'accept_advertising']);
        });
    }
}
