<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HospitalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        // Get all users
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            for($i = 0 ; $i < 100 ; $i ++){
                DB::table('hospitals')->insert([
                    'title' => Str::random(10),
                    'address' => Str::random(20),
                    'body' => Str::random(50),
                    'info' => random_int(0,100),
                    'cover_image' => Str::random(10),
                    'user_id' => $user->id, 
                ]);
            }
        }
    }
}
