<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResolvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolves', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedBigInteger('bid_id')->nullable();
            $table->unsignedBigInteger('issue_id')->nullable();
            $table->unsignedBigInteger('winner_id')->nullable();
            $table->string('temp_submission_date')->nullable();
            $table->string('submission_date')->nullable();
            $table->integer('extension_count')->default(0);
            $table->string('extended_date')->nullable();
            $table->string('previous_resolve_note', 10000)->nullable();
            $table->string('shipped_date')->nullable();
            $table->string('received_date')->nullable();
            $table->unsignedBigInteger('shipper_id')->nullable();


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
        Schema::dropIfExists('resolves');
    }
}
