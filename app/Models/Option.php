<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    // userテーブルとの中間テーブル
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps();
    }
    // questionテーブルの従テーブル
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }
}
