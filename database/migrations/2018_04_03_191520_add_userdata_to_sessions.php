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
            $table->char('forname', 100)->nullable();
            $table->char('lastname',100)->nullable();
            $table->char('login',100)->nullable();
            $table->char("password",250)->nullable();
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
