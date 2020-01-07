<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNounNatureCitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noun_nature_citations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('citation_id');
            $table->unsignedInteger('nature_id');
            $table->foreign('citation_id')->references('id')->on('citations')->onDelete('cascade');
            $table->foreign('nature_id')->references('id')->on('noun_natures')->onDelete('cascade');
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
        Schema::dropIfExists('noun_nature_citations');
    }
}
