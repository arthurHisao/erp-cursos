<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialiteUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialite_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('social_user_id');
            $table->string('provider_name');
            $table->string('name');
            $table->string('email')->unique(); 
            $table->string('payment_status');
            //$table->foreignId('social_image_id')->nullable()->constrained('user_images')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('socialite_user');
    }
}
