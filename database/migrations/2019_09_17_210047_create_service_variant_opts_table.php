<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceVariantOptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_variant_opts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_variant_id')->unsigned()->index()->nullable();
            $table->foreign('service_variant_id')->references('id')->on('service_variants')->onDelete('cascade')->onUpdate('no action');
            $table->string('name')->nullable();
            $table->double('price', 8, 2)->nullable();
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
        Schema::dropIfExists('service_variant_opts');
    }
}
