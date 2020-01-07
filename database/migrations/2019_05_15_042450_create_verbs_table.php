<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verbs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pattern_id')->unsigned()->nullable();
            $table->foreign('pattern_id')->references('id')->on('patterns');
            $table->integer('syntaxical_rule_id')->unsigned()->nullable();
            $table->foreign('syntaxical_rule_id')->references('id')->on('verb_syntaxical_rule');
            $table->integer('phonological_rule_id')->unsigned()->nullable();
            $table->foreign('phonological_rule_id')->references('id')->on('verb_phonological_rule');
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
        Schema::dropIfExists('verbs');
    }
}
