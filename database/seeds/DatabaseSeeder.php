<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(QuestionCategoryTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
        $this->call(HintTableSeeder::class);        
        $this->call(OptionTableSeeder::class);        
    }
}
