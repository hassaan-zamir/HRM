<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpWorkExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_work_experience', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('emp_id');
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->string('work_title')->nullable();
            $table->text('work_description')->nullable();
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
        Schema::dropIfExists('emp_work_experience');
    }
}
