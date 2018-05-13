<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSentences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sentences')) {
            Schema::create('sentences', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('message_id')->nullable();
                $table->foreign('message_id')->references('id')->on('message')->onDelete('cascade')->onUpdate('cascade');
                $table->longText("sentence");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sentences');
    }
}
