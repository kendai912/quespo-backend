<?php

use Illuminate\Database\Seeder;
use App\Models\Hint;
use Carbon\Carbon;

class HintTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::today();
        if (($handle = fopen(__DIR__ . '/csv/HintData.csv', 'r')) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle)))  {
                // 先頭行はスキップ
                if($i == 0){
                    $i++;
                    continue;
                }
                else {
                    Hint::insert([
                        'question_id' => $data[0], 
                        'text' => $data[1],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
            fclose($handle);
        } 
    }
}
