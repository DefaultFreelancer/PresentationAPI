<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('word')->references('id')->on('words');
            $table->text('citation');
            $table->integer('source')->references('id')->on('sources')->nullable();

            $table->bigInteger('gregorian_date_from')->nullable();
            $table->bigInteger('gregorian_date_to')->nullable();
            $table->bigInteger('hijri_date_from')->nullable();
            $table->bigInteger('hijri_date_to')->nullable();

            $table->integer('approximate')->references('id')->on('approximate_dates')->nullable();
            $table->integer('era')->references('id')->on('eras')->nullable();
            $table->text('bibliographicInfo')->nullable();
            $table->text('meaning')->nullable();

            $table->integer('miItem');
            $table->integer('miPage');
            $table->json('miReference')->nullable();
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
        Schema::dropIfExists('citations');
    }
}
