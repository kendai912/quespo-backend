<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionArea extends Model
{
    // スコープ定義
    public function scopeIndexAreaSelect($query)
    {
        return $query->addSelect(['question_category_id','address','latitude','longitude']);
    }
}
