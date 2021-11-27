<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //optionテーブルの主テーブル
    public function options(){
        return $this->hasMany('App\Models\Option');
    }

    // QuestionCategoryテーブルの従テーブル
    public function questionCategory(){
        return $this->belongsTo('App\Models\QuestionCategory');
    }

}
