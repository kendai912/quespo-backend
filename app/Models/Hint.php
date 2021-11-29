<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hint extends Model
{
    // スコープ定義
    public function scopeDefaultSelect($query)
    {
        return $query->addSelect(['question_id','text as hint_text']);
    }
}
