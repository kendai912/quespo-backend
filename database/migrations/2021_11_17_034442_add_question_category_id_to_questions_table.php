<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuestionCategoryIdToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('question_category_id')->after("id");

            $table->foreign('question_category_id')->references('id')->on('question_categories')->onDelete('cascade');
            $table->unique(['id','question_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign('questions_question_category_id_foreign');
            $table->dropUnique('questions_id_question_category_id_unique');
            $table->dropColumn('question_category_id');
        });
    }
}
