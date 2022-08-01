<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('alarm')->nullable();
            $table->string('occuring_time')->nullable();
            $table->string('problem_history')->nullable();
            $table->string('description')->nullable();
            $table->string('steps_taken')->nullable();
            $table->string('status')->nullable();
            $table->string('photo')->nullable();
            $table->string('solve_note')->nullable();
            $table->timestamps();
            $table->string('center');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
