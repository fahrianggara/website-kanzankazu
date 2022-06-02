<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_messages')->insert([
            'title' => 'Email Verification',
            'subject' => 'Selamat datang di KanzanKazu',
            'action' => 'NEWSLETTER_SUBSCRIPTION_CUSTOMER',
            'body' => 'Terimakasih sudah berlangganan di KanzanKazu, kamu akan mendapatkan informasi dan tutorial yang lebih awal.',
        ]);
    }
}
