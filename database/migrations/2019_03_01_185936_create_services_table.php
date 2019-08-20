<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->double('price', 8, 2);
            $table->string('thumbnail')->nullable();
            $table->boolean('display')->nullable()->default(1);
            $table->boolean('requirments')->nullable()->default(1);
            $table->boolean('deadline')->nullable()->default(0);
            $table->integer('deadline_number')->nullable();
            $table->string('deadline_type')->nullable();
            $table->integer('order')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(1);
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
        Schema::dropIfExists('services');
    }
}
