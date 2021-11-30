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
        $complete_flag = null;
        $numOfQuestion = null;
        // ログインユーザーID(1) ※Postmanを使う際はここを数字(任意のuserid)に置き換える
        // $uid = Auth::id();
        $uid = 1;
        //クエスチョンカテゴリーのID一覧(2) 
        $questionCategoryIds = QuestionCategory::pluck('id');
        // (1)(2)を引数に各カテゴリーのユーザーの回答レコードを取得
        foreach($questionCategoryIds as $i => $cid){
            // 'option_user','options','questionsno'の３テーブルを繋げてレコード取得
            $user_ans = Option::whereHas('users', function ($q) use ($uid){
                $q->where('user_id', $uid)->where(function($custom_q){
                    $custom_q->where('status','true')->orWhere('status','false_2');
                });
            })->whereHas('question',function($q) use($cid) {
                $q->where('question_category_id', $cid);
            })->count();

            $numOfQuestion = Question::whereHas('questionCategory', function($q) use ($i){
                $q->where('id',$i+1);
            })->count();

            // ５問回答済みの場合は回答フラグをtrue/それ以外はfalse
            if($user_ans === $numOfQuestion){
                $complete_flag = true;
                // $questionCategoryに連想配列形式で'complete_flag'を追加
            } else {
                $complete_flag = false;  
            }
            $questionCategory[$i]['complete_flag'] = $complete_flag;
            $questionCategory[$i]['num_of_question'] = $numOfQuestion;
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
    public function show($questionCategory)
    {
        $queryCategory = QuestionCategory::where('id',$questionCategory)->With('questionArea')->defaultSelect()->get();
       
        // (1)選択カテゴリーの問題数を取得
        $numOfQuestion = Question::whereHas('questionCategory', function($q) use ($questionCategory){
            $q->where('id',$questionCategory);
        })->count();

        // (2)引数取得...選択カテゴリーの問題一覧から先頭の質問idと末尾の質問idを取得
        $i_Start = Question::Where('question_category_id',$questionCategory)->pluck('id')->first();
        $i_End = Question::Where('question_category_id',$questionCategory)->orderBy('id','desc')->pluck('id')->first();

        // (1)(2)を引数に[問題:[選択肢:val]]形式のレコード作成
        // questions,hints,optionsテーブルからレコード取得
        $queryQuestionOptions = Question::with('hint')->with(['options'=> function($q) use ($i_Start,$i_End){
            $q->whereBetween('question_id',[$i_Start,$i_End] );
        }])->where('question_category_id',$questionCategory)->defaultSelect()->get();
     
        return response()->json([
            'questionCategory' => json_decode($queryCategory, true),
            'questions' => json_decode($queryQuestionOptions, true)
        ],200);
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
