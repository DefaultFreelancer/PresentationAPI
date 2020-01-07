<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjectives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('adjective_pattern_id')->unsigned()->nullable();
            $table->foreign('adjective_pattern_id')->references('id')->on('patterns');
            $table->integer('type_pattern_id')->unsigned()->nullable();
            $table->foreign('type_pattern_id')->references('id')->on('adjective_type_pattern');
            $table->string('past_participle')->nullable();
            $table->integer('pattern_past_participle_id')->unsigned()->nullable();
            $table->foreign('pattern_past_participle_id')->references('id')->on('patterns');
            $table->string('assimilated')->nullable();
            $table->integer('pattern_assimilated_id')->unsigned()->nullable();
            $table->foreign('pattern_assimilated_id')->references('id')->on('patterns');
            $table->string('mobalagha')->nullable();
            $table->integer('pattern_mobalagha_id')->unsigned()->nullable();
            $table->foreign('pattern_mobalagha_id')->references('id')->on('patterns');
            $table->string('comperative')->nullable();
            $table->integer('pattern_comperative_id')->unsigned()->nullable();
            $table->foreign('pattern_comperative_id')->references('id')->on('patterns');
            $table->string('period_participle')->nullable();
            $table->integer('pattern_period_participle_id')->unsigned()->nullable();
            $table->foreign('pattern_period_participle_id')->references('id')->on('patterns');
            $table->string('place_participle')->nullable();
            $table->integer('pattern_place_participle_id')->unsigned()->nullable();
            $table->foreign('pattern_place_participle_id')->references('id')->on('patterns');
            $table->string('machine_participle')->nullable();
            $table->integer('pattern_machine_participle_id')->unsigned()->nullable();
            $table->foreign('pattern_machine_participle_id')->references('id')->on('patterns');
            $table->string('verb')->nullable();
            $table->integer('pattern_verb_id')->unsigned()->nullable();
            $table->foreign('pattern_verb_id')->references('id')->on('patterns');
            $table->string('ala_id')->nullable();
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
        Schema::dropIfExists('adjectives');
    }
}
