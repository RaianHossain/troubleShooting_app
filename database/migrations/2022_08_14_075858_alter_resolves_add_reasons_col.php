<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterResolvesAddReasonsCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resolves', function (Blueprint $table) {
            if(!Schema::hasColumn('resolves', 'reason'))
            {
                $table->string('reason')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resolves', function (Blueprint $table) {
            if(Schema::hasColumn('resolves', 'reason'))
            {
                $table->dropColumn('reason');
            }
        });
    }
}
