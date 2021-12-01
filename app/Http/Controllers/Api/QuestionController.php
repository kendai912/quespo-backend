<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($question)
    {
        /**
         * @param $question_id
         * questions,hints,optionsテーブルからレコード取得
         * @return ...[question:[option:val]]
         */ 
        // 
        $queryQuestionOptions = Question::with('hint')->with(['options'=> function($q) use($question){
            $q->where('question_id', $question);
        }])->where('id',$question)->defaultSelect()->first();;

        /**
         * OK @param $use_id, $question_id
         * @return $status 
         */
        $uid = Auth::id();
        $status = DB::table('option_user')->join('options', 'option_user.option_id', '=', 'options.id')
            ->where([['user_id',$uid],['question_id',$question]])
            ->orderBy('option_user.created_at','desc')
            ->pluck('status')->first();
        // statusをquestionレコードにセット
        $queryQuestionOptions['status'] = $status;
        return response()->json([
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
