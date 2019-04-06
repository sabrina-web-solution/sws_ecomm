<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('system_id')->unsigned();
            $table->foreign('system_id')->references('id')->on('system_type');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('recovery_email')->nullable();
            $table->string('email_verification_token')->nullable();
            $table->string('access_token')->nullable();
            $table->enum('social_type',['manual','fb','gm'])->default('manual');
            $table->string('social_token')->nullable();
            $table->rememberToken();
            $table->dateTime('email_verified_at')->nullable();
            $table->dateTime('password_reset_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
