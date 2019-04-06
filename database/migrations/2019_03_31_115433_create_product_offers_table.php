<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('offer_name',255);
            $table->enum('offer_type',['amt','per','combo'])->default('amt');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('venue_id')->unsigned();
            $table->foreign('venue_id')->references('id')->on('venues');
            $table->integer('merchant_id')->unsigned();
            $table->foreign('merchant_id')->references('id')->on('merchants');
            $table->integer('modifier_id')->unsigned();
            $table->foreign('modifier_id')->references('id')->on('product_modifiers');
            $table->decimal('discount_amt',8,2);
            $table->text('combo_product_ids')->nullable();
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
        Schema::dropIfExists('product_offers');
    }
}
