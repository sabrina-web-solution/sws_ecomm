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
            $table->integer('payment_id')->unique();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('order_master_id')->unsigned();
            $table->foreign('order_master_id')->references('id')->on('order_masters');
            $table->decimal('totalamount',10,2)->default('0.0');
            $table->decimal('cancelamount',10,2)->default('0.0');
            $table->integer('totalitems')->default('0');
            $table->integer('returneditems')->default('0');            
            $table->timestamp('order_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('returned_date')->nullable();
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
