<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TutorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tutorials')->insert([
            [
                'title' => 'HTML',
                'slug' => 'html',
                'description' => '',
                'thumbnail' => 'default.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'PHP',
                'slug' => 'php',
                'description' => '',
                'thumbnail' => 'default.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Laravel',
                'slug' => 'laravel',
                'description' => '',
                'thumbnail' => 'default.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
