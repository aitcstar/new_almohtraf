<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('firstname');
                $table->string('familyname');
                $table->string('country')->nullable();;
                $table->string('gender')->nullable();;
                $table->date('birthday')->nullable();;
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('email_code')->nullable();
                $table->string('phone')->unique()->nullable();;
                $table->timestamp('phone_verified_at')->nullable();
                $table->string('phone_code')->nullable();
                $table->string('personal_identification')->nullable();
                $table->timestamp('identification_verified_at')->nullable();
                $table->string('password');
                $table->unsignedBigInteger('category_id')->nullable();
                $table->unsignedBigInteger('subcategory_id')->nullable();
                $table->text('biography')->nullable();
                $table->string('video')->nullable();
                $table->string('profile_picture')->nullable();
                $table->string('how_did_you_hear_about_us')->nullable();


                $table->date('date_registration')->nullable();
                $table->timestamp('last_login')->nullable();
                $table->integer('boarding')->default(0);
                $table->unsignedBigInteger('role_id')->default(2);

                $table->unsignedBigInteger('country_id')->nullable();
                $table->unsignedBigInteger('language_id')->nullable();
                $table->unsignedBigInteger('freelancer_availability')->default(0);



                $table->rememberToken();
                $table->timestamps();


                $table->foreign('role_id')->references('id')->on('roles');
                $table->foreign('category_id')->references('id')->on('categories');


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
};
