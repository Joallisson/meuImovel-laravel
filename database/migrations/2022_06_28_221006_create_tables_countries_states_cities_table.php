<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesCountriesStatesCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) { //tables_countries_states_cities
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('initials');
            $table->timestamps();
        });

        Schema::create('states', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('country_id');
            //$table->foreignId('country_id')->constrained(); => assim também da certo e o jeito mais atual

            $table->string('name');
            $table->string('slug');
            $table->string('initials');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries');

        });

        Schema::create('cities', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('state_id');
            //$table->foreignId('country_id')->constrained(); => assim também da certo e o jeito mais atual

            $table->string('name');
            $table->string('slug');
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
        Schema::dropIfExists('countries');
    }
}
