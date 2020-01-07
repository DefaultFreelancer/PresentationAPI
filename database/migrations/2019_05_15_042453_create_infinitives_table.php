<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfinitivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infinitives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pattern_id')->unsigned()->nullable();
            $table->foreign('pattern_id')->references('id')->on('patterns');
            $table->string('verb')->nullable();
            $table->integer('pattern_verb_id')->unsigned()->nullable();
            $table->foreign('pattern_verb_id')->references('id')->on('patterns');
            $table->string('hayaah')->nullable();
            $table->integer('pattern_hayaah_id')->unsigned()->nullable();
            $table->foreign('pattern_hayaah_id')->references('id')->on('patterns');
            $table->string('meme')->nullable();
            $table->integer('pattern_meme_id')->unsigned()->nullable();
            $table->foreign('pattern_meme_id')->references('id')->on('patterns');
            $table->string('making')->nullable();
            $table->integer('pattern_making_id')->unsigned()->nullable();
            $table->foreign('pattern_making_id')->references('id')->on('patterns');
            $table->string('inf_time')->nullable();
            $table->integer('pattern_time_id')->unsigned()->nullable();
            $table->foreign('pattern_time_id')->references('id')->on('patterns');
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
        Schema::dropIfExists('infinitives');
    }
}
