<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UserSeeder::class,
            TweetSeeder::class,
            LikesSeeder::class
        ]);

        foreach (range(1,100) as $item){
            app('db')->table('likes')->insert([
                'user_id'=>DB::table('users')
                    ->inRandomOrder()
                    ->first()->id,
                'tweet_id'=>DB::table('tweets')
                    ->inRandomOrder()
                    ->first()->id,
            ]);
        }
    }
}
