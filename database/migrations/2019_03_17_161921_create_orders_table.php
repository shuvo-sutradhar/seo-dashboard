<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');

            $table->integer('service_id')->unsigned()->index()->nullable();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('no action');
            
            $table->integer('team_member_id')->unsigned()->nullable();
            $table->foreign('team_member_id')->references('id')->on('users')->onDelete('set null')->onUpdate('no action');

            $table->string('order_number');
            $table->text('order_note')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('order_status')->nullable();
            $table->string('payment_staus')->nullable();
            $table->timestamp('strated_at')->nullable();
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
