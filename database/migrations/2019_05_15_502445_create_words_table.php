<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text');
            $table->integer('root')->unsigned();
            $table->foreign('root')->references('id')->on('roots');
            $table->integer('type')->unsigned();
            $table->foreign('type')->references('id')->on('word_types');
            $table->integer('noun_id')->unsigned()->nullable();
            $table->foreign('noun_id')->references('id')->on('nouns');
            $table->integer('verb_id')->unsigned()->nullable();
            $table->foreign('verb_id')->references('id')->on('verbs');
            $table->integer('adjective_id')->unsigned()->nullable();
            $table->foreign('adjective_id')->references('id')->on('adjectives');
            $table->integer('infinitive_id')->unsigned()->nullable();
            $table->foreign('infinitive_id')->references('id')->on('infinitives');
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
        Schema::dropIfExists('words');
    }
}
