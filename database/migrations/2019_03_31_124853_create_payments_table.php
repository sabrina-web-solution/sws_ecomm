<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_code')->unique();
            $table->integer('system_id')->unsigned();
            $table->foreign('system_id')->references('id')->on('system_type');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('order_masters');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('payment_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->decimal('paid',10,2)->default('0.0');
            $table->enum('status',['order','cancel'])->default('order');
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
