<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\QuestionArea;

class QuestionAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::today();
        if (($handle = fopen(__DIR__ . '/csv/QuestionArea.csv', 'r')) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle)))  {
                // 先頭行はスキップ
                if($i == 0){
                    $i++;
                    continue;
                }
                else {
                    QuestionArea::insert([
                        'question_category_id' => $data[0], 
                        'address' => $data[1],
                        'latitude' => $data[2],
                        'longitude' => $data[3],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
            fclose($handle);
        }     
    }
}
