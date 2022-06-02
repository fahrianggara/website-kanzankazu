<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('web_settings')->insert([
            'site_name' => 'KanzanKazu',
            'site_description' => 'Website Sederhana dengan seputar web development, serta berbagi source code dan tutorial lainnya.',
            'site_footer' => '© ' . date('Y') . ' KanzanKazu.',
            'site_email' => 'kanzankazu@protonmail.com',
            'site_twitter' => 'https://twitter.com/kanzankazu',
            'site_github' => 'https://github.com/kanzankazu',
            'meta_keywords' => 'kanzankazu, kanzan, kazu, ',
            'image_banner' => 'banner_image.png',
        ]);
    }
}
