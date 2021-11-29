<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::today();
        $token_01 = Str::random(80);
        User::insert([
            'name' => '一般ユーザー01',
            'email' => 'user@test01.com',
            'password' => Hash::make('password01'),
            'api_token' => hash('sha256', $token_01),
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $token_02 = Str::random(80);    
        User::insert([
            'name' => '一般ユーザー02',
            'email' => 'user@test02.com',
            'password' => Hash::make('password02'),
            'remember_token' => Str::random(10),
            'api_token' => hash('sha256', $token_02),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $token_03 = Str::random(80);           
        User::insert([
            'name' => '一般ユーザー03',
            'email' => 'user@test03.com',
            'password' => Hash::make('password03'),
            'remember_token' => Str::random(10),
            'api_token' => hash('sha256', $token_03),
            'created_at' => $now,
            'updated_at' => $now,
        ]);    
    }
}
