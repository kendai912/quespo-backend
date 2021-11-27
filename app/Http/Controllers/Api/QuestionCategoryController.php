<?php

namespace App\Http\Controllers\Api;

use App\Models\QuestionCategory;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\Option;
use Illuminate\Http\Request;

class QuestionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {        
        $questionCategory = QuestionCategory::with('questionArea')->defaultSelect()->get();
        // ログインユーザーID(1) ※Postmanを使う際はここを数字(任意のuserid)に置き換える
        $uid = Auth::id();
        //クエスチョンカテゴリーのID一覧(2) 
        $questionCategoryIds = QuestionCategory::pluck('id');
        // (1)(2)を引数に各カテゴリーのユーザーの回答レコードを取得
        foreach($questionCategoryIds as $i => $id){
            // 'option_user','options','questionsno'の３テーブルを繋げてレコード取得
            $complete_flag = Option::whereHas('users', function ($q) use ($uid) {
                $q->where('user_id', $uid);
            })->whereHas('question',function($q) use ($id){
                $q->where('question_category_id', $id);
            })->count();
            // ５問回答済みの場合は回答フラグをtrue/それ以外はfalse
            if($complete_flag === 5){
                $complete_flag = true;
                // $questionCategoryに連想配列形式で'complete_flag'を追加
                $questionCategory[$i]['complete_flag'] = $complete_flag;
            } else {
                $complete_flag = false;  
            }
        }
        return response()->json([
            'QuestionCategories' => json_decode($questionCategory, true)
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
