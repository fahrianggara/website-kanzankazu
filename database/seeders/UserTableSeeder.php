<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        DB::table('users')->insert([
            [
                'name'              => 'Kanzan',
                'email'             => 'kanzan@gmail.com',
                'password'          => Hash::make('kanzan@121212'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
                'created_at'        => date('Y:m:d H:i:s'),
                'updated_at'        => date('Y:m:d H:i:s'),
                'slug'              => 'kanzan'
            ],
            [
                'name'              => 'Zexpher',
                'email'             => 'zexpher@gmail.com',
                'password'          => Hash::make('zexpher@301203'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
                'created_at'        => date('Y:m:d H:i:s'),
                'updated_at'        => date('Y:m:d H:i:s'),
                'slug'              => 'zexpher'
            ]
        ]);
    }
}
