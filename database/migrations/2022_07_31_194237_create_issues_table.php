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
            $table->string('problem_history', 5000)->nullable();
            $table->string('description', 5000)->nullable();
            $table->string('steps_taken', 2000)->nullable();
            $table->string('status')->nullable();
            $table->string('imageOne')->nullable();
            $table->string('solve_note', 2000)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('center_id')->nullable();
            $table->string('code')->nullable();
            $table->string('imageTwo')->nullable();
            $table->string('imageThree')->nullable();
            $table->unsignedBigInteger('shipper_id')->nullable();

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
