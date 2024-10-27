<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('social_user_id')->unsigned()->nullable();
            $table->bigInteger('admin_id')->unsigned()->nullable();
            //relacionamentos
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('social_user_id')->references('id')->on('socialite_users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admin_id')->references('id')->on('user_admins')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('user_images');
    }
}
