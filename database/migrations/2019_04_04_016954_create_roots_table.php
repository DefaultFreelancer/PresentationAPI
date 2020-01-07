<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRootsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('root');
            $table->integer('class_id')->unsigned()->index()->nullable();
            $table->foreign('class_id')->references('id')->on('root_classes');
            //$table->integer('pattern_id')->unsigned()->index()->nullable();
            //$table->foreign('pattern_id')->references('id')->on('patterns');
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
        Schema::dropIfExists('roots');
    }
}
