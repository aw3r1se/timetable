<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_segments', function (Blueprint $table) {
            $table->id();

            if (config('timetable.segment.relation_name')) {
                $table->morphs('scheduleable');
            }

            $table->date('date')->index();
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            if (config('timetable.segment.unique_index')) {
                $table->unique([
                    'date',
                    'start_time',
                    'end_time',
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_segments');
    }
};
