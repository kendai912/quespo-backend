<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LineFriendPushMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_friend_push_message', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('line_friend_id');
            $table->unsignedBigInteger('push_message_id');
            $table->timestamps();

            // プッシュメッセージの送信者一覧を管理する中間テーブル
            $table->foreign('line_friend_id')->references('id')->on('line_friends')->onDelete('cascade');
            $table->foreign('push_message_id')->references('id')->on('push_messages')->onDelete('cascade');
            $table->unique(['line_friend_id', 'push_message_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_friend_push_message');
    }
}