<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'title' => 'HTML',
                'slug' => 'html',
                'description' => '',
                'thumbnail' => 'default.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
            ],
            [
                'title' => 'CSS',
                'slug' => 'css',
                'description' => '',
                'thumbnail' => 'default.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
            ],
            [
                'title' => 'Javascript',
                'slug' => 'javascript',
                'description' => '',
                'thumbnail' => 'default.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
            ],
            [
                'title' => 'PHP',
                'slug' => 'php',
                'description' => '',
                'thumbnail' => 'default.png',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
            ],
        ]);
    }
}
