<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    // スコープ定義
    public function scopeDefaultSelect($query)
    {
        return $query->addSelect(['id as option_id','question_id','outcome','text as option_text',]);
    }    

    // userテーブルとの中間テーブル
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('status')->withTimestamps();
    }
    // questionテーブルの従テーブル
    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }
}
