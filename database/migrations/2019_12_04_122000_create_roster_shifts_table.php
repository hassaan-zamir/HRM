<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRosterShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roster_shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->time('start_time');
            $table->float('shift_duration');
            $table->float('lunch_duration')->default(0);
            $table->float('late_time');
            $table->float('early_go_time');
            $table->float('overtime_start_time');
            $table->integer('sunday_check')->default(0);
            $table->time('sunday_start_time')->nullable();
            $table->float('sunday_shift_duration')->nullable();
            $table->float('sunday_lunch_duration')->default(0);
            $table->float('sunday_late_time')->nullable();
            $table->float('sunday_early_go_time')->nullable();
            $table->float('sunday_overtime_start_time')->nullable();
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
        Schema::dropIfExists('roster_shifts');
    }
}
