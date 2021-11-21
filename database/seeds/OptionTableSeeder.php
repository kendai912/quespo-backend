<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Option;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::today();
        if (($handle = fopen(__DIR__ . '/csv/OptionData.csv', 'r')) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle)))  {
                // 先頭行はスキップ
                if($i == 0){
                    $i++;
                    continue;
                }else{
                    Option::insert([
                        'question_id' => $data[0], 
                        'outcome' => $data[1],
                        'text' => $data[2],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
            fclose($handle);
        }
    }
}
