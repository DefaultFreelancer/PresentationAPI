<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNounsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nouns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pattern_id')->unsigned()->nullable();
            $table->foreign('pattern_id')->references('id')->on('patterns');
            $table->integer('pattern_plural_id')->unsigned()->nullable();
            $table->foreign('pattern_plural_id')->references('id')->on('patterns');
            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('noun_type');
            $table->string('plural')->nullable();
            $table->integer('class_plural_id')->unsigned()->nullable();
            $table->foreign('class_plural_id')->references('id')->on('noun_class_plural');
            $table->string('the_with_noun')->nullable();
            $table->integer('sex_id')->unsigned()->nullable();
            $table->foreign('sex_id')->references('id')->on('noun_sex');
            $table->integer('sex_how_id')->unsigned()->nullable();
            $table->foreign('sex_how_id')->references('id')->on('noun_sex_how');
            $table->string('dual_male')->nullable();
            $table->string('dual_female')->nullable();
            $table->string('female')->nullable();
            $table->integer('attribution_id')->unsigned()->nullable();
            $table->foreign('attribution_id')->references('id')->on('noun_attribution');
            $table->string('attribution_text')->nullable();
            $table->integer('minimize_id')->unsigned()->nullable();
            $table->foreign('minimize_id')->references('id')->on('noun_minimize');
            $table->string('minimize_text')->nullable();
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
        Schema::dropIfExists('nouns');
    }
}
