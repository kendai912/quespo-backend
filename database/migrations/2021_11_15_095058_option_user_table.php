<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OptionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_user', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');       
            $table->unsignedBigInteger('option_id');
            $table->string('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->unique(['option_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_user');
    }
}
