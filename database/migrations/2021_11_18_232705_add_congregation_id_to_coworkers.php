<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCongregationIdToCoworkers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coworkers', function (Blueprint $table) {
            $table->foreignId('congregation_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coworkers', function (Blueprint $table) {
            $table->dropForeign('coworkers_congregation_id_foreign');
        });
    }
}
