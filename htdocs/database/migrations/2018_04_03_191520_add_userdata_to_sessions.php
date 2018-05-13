<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserdataToSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessions', function($table) {
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('login')->nullable();
            $table->string("password")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sessions', function($table) {
            $table->dropColumn('forname');
            $table->dropColumn('lastname');
            $table->dropColumn('login');
            $table->dropColumn('password');
        });
    }

}
