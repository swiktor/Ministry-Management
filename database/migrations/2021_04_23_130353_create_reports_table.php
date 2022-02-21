<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ministry_id')->constrained();
            $table->time('hours')->nullable()->default("00:00:00");
            $table->integer('placements')->nullable()->default(0);
            $table->integer('videos')->nullable()->default(0);
            $table->integer('returns')->nullable()->default(0);
            $table->integer('studies')->nullable()->default(0);
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
        Schema::dropIfExists('reports');
    }
}
