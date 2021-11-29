<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hint extends Model
{
    // スコープ定義
    public function scopeDefaultSelect($query)
    {
        return $query->addSelect(['id','question_id','text']);
    }
}
