<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCategory extends Model
{

    // スコープ定義
    public function scopeDefaultSelect($query)
    {
        return $query->addSelect(['id','title','body','created_at']);
    }

    // QuestionAreaテーブルと1対1
    public function questionArea(){
        return $this->hasOne('App\Models\QuestionArea')->indexAreaSelect();
    }

    // Questionテーブルの主テーブル
    public function questions(){
        return $this->hasMany('App\Models\Question');
    }

}
