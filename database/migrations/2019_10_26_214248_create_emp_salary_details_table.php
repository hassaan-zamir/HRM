<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpSalaryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_salary_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('salary')->nullable();
            $table->integer('fuel_allowance')->default(0)->nullable();
            $table->integer('mobile_allowance')->default(0)->nullable();
            $table->integer('other_allowance')->default(0)->nullable();
            $table->boolean('late_early_deductions')->nullable();
            $table->boolean('late_penalty')->nullable();
            $table->boolean('hourly_overtime_allow')->nullable();
            $table->boolean('holiday_overtime_allow')->nullable();
            $table->boolean('short_duty_hours')->nullable();
            $table->integer('monthly_casual_allow')->default(0)->nullable();
            $table->integer('total_casual_allow')->default(0)->nullable();
            $table->integer('monthly_annual_allow')->default(0)->nullable();
            $table->integer('total_annual_allow')->default(0)->nullable();
            $table->integer('emp_id');
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
        Schema::dropIfExists('emp_salary_details');
    }
}
