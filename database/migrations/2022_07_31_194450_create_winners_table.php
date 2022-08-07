<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->stirng('endingAt')->nullable();
            $table->unsignedBigInteger('issue_id')->nullable();
            $table->unsignedBigInteger('bid_id')->nullable();
            $table->integer('position')->nullable();
            $table->integer('extensionCount')->default(0);
            $table->string('extended_date')->nullable();
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
        Schema::dropIfExists('winners');
    }
}
