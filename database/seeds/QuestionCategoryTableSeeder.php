<?php

use Illuminate\Database\Seeder;
use App\Models\QuestionCategory;
use Carbon\Carbon;

class QuestionCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::today();
        if (($handle = fopen(__DIR__ . '/csv/QuestionCategoryData.csv', 'r')) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle)))  {
                // 先頭行はスキップ
                if($i == 0){
                    $i++;
                    continue;
                }
                else {
                    QuestionCategory::insert([
                        'title' => $data[0], 
                        'body' => $data[1],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
            fclose($handle);
        } 
    }
}
