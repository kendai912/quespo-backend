<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // スコープ定義
    public function scopeDefaultSelect($query)
    {
        return $query->addSelect(['id','text as question_text','commentary','img_file_name as img_file_name_question','created_at']);
    }

    //optionテーブルの主テーブル
    public function options(){
        return $this->hasMany('App\Models\Option');
    }

    // QuestionCategoryテーブルの従テーブル
    public function questionCategory(){
        return $this->belongsTo('App\Models\QuestionCategory');
    }

    // Hintテーブルと1対1
    public function hint(){
        return $this->hasOne('App\Models\Hint')->defaultSelect();
    }
}



// App\Models\Option::whereHas('users', function ($q) {
//     $q->where('user_id', 1)->where(function($tst){
//         $tst->where('status','true')->orWhere('status','false_2');
//     });
// })->whereHas('question',function($q) {
//     $q->where('question_category_id', 1);
// })->count();

// OK
// DB::table('option_user')->where([['user_id', 1],['question_category_id',1]])->Where(function($q){
//     $q->where('status','true')->orWhere('status','false_2');
// })->get();