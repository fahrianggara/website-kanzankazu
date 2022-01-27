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
                'name'              => 'Mimin',
                'email'             => 'mimin@zex.com',
                'password'          => Hash::make('mimin@zex301203'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
                'created_at'        => date('Y:m:d H:i:s'),
                'updated_at'        => date('Y:m:d H:i:s'),
                'slug'              => 'mimin'
            ],
            [
                'name'              => 'Admin',
                'email'             => 'admin@zex.com',
                'password'          => Hash::make('admin@zex301203'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
                'created_at'        => date('Y:m:d H:i:s'),
                'updated_at'        => date('Y:m:d H:i:s'),
                'slug'              => 'admin'
            ],
            [
                'name'              => 'Creator',
                'email'             => 'creator@zex.com',
                'password'          => Hash::make('creator@zex301203'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
                'created_at'        => date('Y:m:d H:i:s'),
                'updated_at'        => date('Y:m:d H:i:s'),
                'slug'              => 'creator'
            ],
        ]);
    }
}
