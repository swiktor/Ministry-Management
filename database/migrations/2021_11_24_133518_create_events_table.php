<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // Relationships.
            $table->foreignId('calendar_id')->onDelete('cascade')->constrained();

            // Data.
            $table->string('google_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('allday')->default(false);

            // Timestamps.
            $table->datetime('started_at');
            $table->datetime('ended_at');
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
        Schema::dropIfExists('events');
    }
}
