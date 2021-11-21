<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

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
        User::insert([
            'name' => '一般ユーザー01',
            'email' => 'user@test01.com',
            'email_verified_at' => $now,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);    
        User::insert([
            'name' => '一般ユーザー02',
            'email' => 'user@test02.com',
            'email_verified_at' => $now,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);    
        User::insert([
            'name' => '一般ユーザー03',
            'email' => 'user@test03.com',
            'email_verified_at' => $now,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => $now,
            'updated_at' => $now,
        ]);    
    }
}
