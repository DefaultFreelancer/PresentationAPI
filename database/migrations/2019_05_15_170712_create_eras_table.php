<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('gregorianFrom');
            $table->integer('gregorianTo');
            $table->integer('hijriFrom');
            $table->integer('hijriTo');
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('name');
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
        Schema::dropIfExists('eras');
    }
}
