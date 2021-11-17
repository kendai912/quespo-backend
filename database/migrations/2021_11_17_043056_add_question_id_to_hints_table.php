<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuestionIdToHintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hints', function (Blueprint $table) {
            $table->unsignedBigInteger('question_id')->after("id");

            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->unique(['id','question_id']);        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hints', function (Blueprint $table) {
            $table->dropForeign('hints_question_id_foreign');
            $table->dropUnique('hints_id_question_id_unique');
            $table->dropColumn('question_id');
        });
    }
}
