<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPorfolioToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pf_vision')->nullable()->after('status');
            $table->string('pf_mission')->nullable()->after('pf_vision');
            $table->string('pf_resume')->nullable()->after('pf_mission');
            $table->string('pf_skill_desc')->nullable()->after('pf_resume');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
