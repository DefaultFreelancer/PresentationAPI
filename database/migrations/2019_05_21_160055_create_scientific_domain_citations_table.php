<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScientificDomainCitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scientific_domain_citations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('citation_id');
            $table->unsignedInteger('domain_id');
            $table->foreign('citation_id')->references('id')->on('citations')->onDelete('cascade');
            $table->foreign('domain_id')->references('id')->on('scientific_domains')->onDelete('cascade');
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
        Schema::dropIfExists('scientific_domain_citations');
    }
}
