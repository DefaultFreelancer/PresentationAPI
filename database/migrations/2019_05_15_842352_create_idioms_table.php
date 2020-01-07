<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdiomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idioms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('text');
            $table->integer('root')->unsigned()->nullable();
            $table->foreign('root')->references('id')->on('roots');
            $table->integer('word')->unsigned()->nullable();
            $table->foreign('word')->references('id')->on('words');
            $table->string('ala_id')->nullable();
            $table->string('description')->nullable();
            $table->string('first_word')->nullable();
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
        Schema::dropIfExists('idioms');
    }
}
