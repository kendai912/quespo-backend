<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuestionIdToQuestionAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_areas', function (Blueprint $table) {
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
        Schema::table('question_areas', function (Blueprint $table) {
            $table->dropForeign('question_areas_question_id_foreign');
            $table->dropUnique('question_areas_id_question_id_unique');
            $table->dropColumn('question_id');
        });
    }
}
