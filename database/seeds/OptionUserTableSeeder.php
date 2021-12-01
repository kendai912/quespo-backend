<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Option;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class OptionUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::today();
        $users = User::where('id',1)->orWhere('id',2)->pluck('id')->all();
        $optionsArray = array();

        /** 
         * param $option_id...選択肢id, $options = [ 選択肢id=>outcome, ]
         * return $enum...'true','false_1','false_2'のどれか一つ
        */
        function ans_check(int $option_id, array $options){
            if($options[$option_id] === 1){
                return 'true';
            } else {
                $enum = [ 'false_1','false_2'];
                $i = array_rand($enum);
                return $enum[$i];
            }
        }

        /** 
         * 選択肢を問題毎の２次元連想配列に変換
         * [0:[選択肢id=>outcome],[選択肢id=>outcome],[選択肢id=>outcome]]...
         * $DataSet = questionのテストデータ個数分
        */
        $DataSet = 26;
        for($i = 1; $i <= $DataSet; $i++){
            $options = Option::where('question_id',$i)->orderBy('id','asc')->pluck('outcome','id')->all();
            array_push($optionsArray,$options);
        }

        foreach($users as $user){
            foreach($optionsArray as $options){
                $option_id = array_rand($options);
                $status = ans_check($option_id,$options);
                DB::table('option_user')->insert([
                    'option_id' => $option_id,
                    'user_id' => $user,
                    'status' => $status,
                    'created_at' => $now->subDays(1),
                    'updated_at' => $now,     
                ]);
            }
        }
    }
    

}
