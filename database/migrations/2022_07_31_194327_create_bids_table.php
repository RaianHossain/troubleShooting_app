<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('issue_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('center')->nullable();
            $table->double('score')->nullable();
            $table->integer('timeToFix')->nullable();
            $table->string('sendBackDate')->nullable();
            $table->string('needSupport')->nullable();
            $table->string('needSpare')->nullable();
            $table->integer('possibleCost')->nullable();
            $table->string('haveExistingTask')->nullable();
            $table->timestamps();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
}
