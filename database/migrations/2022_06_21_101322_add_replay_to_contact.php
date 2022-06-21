<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReplayToContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->string('answerer')->nullable();
            $table->string('replay_subject')->nullable();
            $table->text('replay_message')->nullable();
            $table->enum('status', ['unanswered', 'answered', 'delete'])->default('unanswered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->dropColumn('replay_subject');
            $table->dropColumn('replay_message');
            $table->dropColumn('answerer');
            $table->dropColumn('status');
        });
    }
}
