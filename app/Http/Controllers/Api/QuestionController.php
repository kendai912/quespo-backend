<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\QuestionCategory;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        $queryQuestionOptions = Question::with('hint')->with(['options'=> function ($q) use ($question) {
            $q->where('question_id', $question);
        }])->where('id', $question)->defaultSelect()->first();
        ;

        /**
         * OK @param $use_id, $question_id
         * @return $status
         */
        $uid = Auth::id();
        $status = DB::table('option_user')->join('options', 'option_user.option_id', '=', 'options.id')
            ->where([['user_id',$uid],['question_id',$question]])
            ->orderBy('option_user.created_at', 'desc')
            ->pluck('status')->first();
        // statusをquestionレコードにセット
        $queryQuestionOptions['status'] = $status;
        return response()->json([
            'question' => json_decode($queryQuestionOptions, true)
        ], 200);
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
    }

    public function answer(Request $request)
    {
        // 【1.OptionTableのoutcomeから正否を判定】
        $result = Option::find($request->option_id)->outcome;

        // 【2.現状のstatusを確認】
        // 2-1.question_idに紐付くoption_idを取得(選択肢3つ分)
        $optionIds = Option::where('question_id', $request->question_id)->pluck('id');

        // 2-2.option_userテーブルから該当するuser_idとoption_id(3つ)に紐付く現在のstatusを確認
        $user = Auth::user();
        $mostCurrentRecord = DB::table('option_user')->where('user_id', $user->id)->whereIn('option_id', $optionIds)->orderBy('updated_at', 'DESC')->first();
        $mostCurrentStatus = $mostCurrentRecord ? $mostCurrentRecord->status : null;

        // 【3.新しいstatusのレコードを保存】
        if (!$mostCurrentStatus) {
            // 3-1. 現状のstatusがnull(未回答の場合)
            if ($result) { // 正解の場合
                $newStatus = 'true';
                DB::table('option_user')->insert([
                    'user_id' => $user->id,
                    'option_id' => $request->option_id,
                    'status' => $newStatus,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            // $user->options()->attach(
                //     ['user_id' => $user->id],
                //     ['option_id' => $request->option_id],
                //     ['status' => $newStatus],
                // );
            } else {  // 不正解の場合
                $newStatus = 'false_1';
                DB::table('option_user')->insert([
                    'user_id' => $user->id,
                    'option_id' => $request->option_id,
                    'status' => $newStatus,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // $user->options()->attach(
                //     ['user_id' => $user->id],
                //     ['option_id' => $request->option_id],
                //     ['status' => $newStatus],
                // );
            }
        } elseif ($mostCurrentStatus == 'false_1') {
            // 3-2. 現状のstatusがfalse_1の場合
            if ($result) { // 正解の場合
                $newStatus = 'true';
                DB::table('option_user')->insert([
                    'user_id' => $user->id,
                    'option_id' => $request->option_id,
                    'status' => $newStatus,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            // $user->options()->attach(
                //     ['user_id' => $user->id],
                //     ['option_id' => $request->option_id],
                //     ['status' => $newStatus],
                // );
            } else {  // 不正解の場合
                $newStatus = 'false_2';
                DB::table('option_user')->insert([
                    'user_id' => $user->id,
                    'option_id' => $request->option_id,
                    'status' => $newStatus,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                // $user->options()->attach(
                //     ['user_id' => $user->id],
                //     ['option_id' => $request->option_id],
                //     ['status' => $newStatus],
                // );
            }
        } elseif ($mostCurrentStatus == 'false_2' || $mostCurrentStatus == 'true') {
            // 3-3. 現状のstatusがfalse_2又はtrueの場合
            return response()->json(['message' => '既に回答済みです'], 422);
        }

        // 【4.新しいstatusを返却】
        return response()->json(['result' => $newStatus], 201);
    }
}
