<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressIdToRealStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_states', function (Blueprint $table) {
            $table->unsignedBigInteger('address_id')->nullable();

            $table->foreign('address_id')->references('id')->on('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('real_states', function (Blueprint $table) {
            $table->dropForeign('real_states_address_id_foreign');
            $table->dropColumn('address_id');
        });
    }
}
