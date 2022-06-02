<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->text('site_description')->nullable();
            $table->string('site_footer');
            $table->string('site_email');
            $table->string('site_twitter')->nullable();
            $table->string('site_github')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('image_banner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_settings');
    }
}
